<?php

namespace Dewakoding\Jejak\Middleware;

use Closure;
use Illuminate\Http\Request;
use Dewakoding\Jejak\Models\UserJejak;
use Jenssegers\Agent\Agent;
use Exception;

class TrackJejak
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Track jejak after response
        $this->trackJejak($request);

        return $response;
    }

    /**
     * Track user jejak
     */
    protected function trackJejak(Request $request): void
    {
        try {
            // Skip if disabled or certain conditions
            if (!$this->shouldTrack($request)) {
                return;
            }

            $agent = new Agent();
            $agent->setUserAgent($request->userAgent());

            // Save jejak to database
            UserJejak::create([
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'ip_address' => $this->getClientIp($request),
                'user_agent' => $request->userAgent(),
                'url' => $request->path(),
                'full_url' => $request->fullUrl(),
                'method' => $request->method(),
                'page_title' => $this->extractPageTitle($request),
                'referrer' => $request->header('referer'),
                'device_type' => $this->getDeviceType($agent),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'platform' => $agent->platform(),
                'is_mobile' => $agent->isMobile(),
                'is_tablet' => $agent->isTablet(),
                'is_desktop' => $agent->isDesktop(),
                'is_robot' => $agent->isRobot(),
                'visited_at' => now(),
            ]);

        } catch (Exception $e) {
            // Log error if enabled, but don't break the application
            if (config('jejak.log_errors', true)) {
                logger()->error('Jejak Tracking Error: ' . $e->getMessage(), [
                    'url' => $request->fullUrl(),
                    'user_id' => auth()->id(),
                    'session_id' => session()->getId(),
                ]);
            }
        }
    }

    /**
     * Check whether to track or not
     */
    protected function shouldTrack(Request $request): bool
    {
        // Skip if tracking disabled
        if (!config('jejak.enabled', true)) {
            return false;
        }

        // Skip for AJAX if configured
        if (config('jejak.skip_ajax', false) && $request->ajax()) {
            return false;
        }

        // Skip certain routes
        $skipRoutes = config('jejak.skip_routes', []);
        foreach ($skipRoutes as $route) {
            if ($request->is($route)) {
                return false;
            }
        }

        // Skip certain IPs
        $skipIps = config('jejak.skip_ips', []);
        if (in_array($this->getClientIp($request), $skipIps)) {
            return false;
        }

        // Skip if user agent is empty or certain bots
        $userAgent = $request->userAgent();
        if (empty($userAgent)) {
            return false;
        }

        // Skip certain bots if configured
        $skipBots = config('jejak.skip_bots', []);
        foreach ($skipBots as $bot) {
            if (str_contains(strtolower($userAgent), strtolower($bot))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get client IP address
     */
    protected function getClientIp(Request $request): string
    {
        // Try various headers to get real IP
        $ipKeys = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',            // Proxy
            'HTTP_X_FORWARDED_FOR',      // Load balancer/proxy
            'HTTP_X_FORWARDED',          // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxy
            'HTTP_FORWARDED',            // Proxy
            'REMOTE_ADDR'                // Standard
        ];

        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                $ip = $_SERVER[$key];
                if (!empty($ip)) {
                    // If there are multiple IPs, take the first one
                    $ip = explode(',', $ip)[0];
                    $ip = trim($ip);
                    
                    // Validate IP
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                        return $ip;
                    }
                }
            }
        }

        return $request->ip();
    }

    /**
     * Extract page title from request
     */
    protected function extractPageTitle(Request $request): ?string
    {
        // Can be developed to extract title from HTML response
        $route = $request->route();
        
        if ($route && $route->getName()) {
            return $route->getName();
        }
        
        // Fallback to path
        return $request->path();
    }

    /**
     * Determine device type
     */
    protected function getDeviceType(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'mobile';
        }
        
        if ($agent->isTablet()) {
            return 'tablet';
        }
        
        if ($agent->isDesktop()) {
            return 'desktop';
        }
        
        return 'unknown';
    }
}