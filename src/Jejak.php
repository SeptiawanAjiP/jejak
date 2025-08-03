<?php

namespace Dewakoding\Jejak;

use Dewakoding\Jejak\Models\UserJejak;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Jejak
{
    /**
     * Get jejak for a specific user
     */
    public function getUserJejak(int $userId, int $limit = 50): Collection
    {
        return UserJejak::forUser($userId)
            ->with('user')
            ->orderBy('visited_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get jejak for a specific session
     */
    public function getSessionJejak(string $sessionId): Collection
    {
        return UserJejak::forSession($sessionId)
            ->orderBy('visited_at', 'asc')
            ->get();
    }

    /**
     * Get popular pages
     */
    public function getPopularPages(int $limit = 10, $timeframe = '30 days'): Collection
    {
        return UserJejak::select('url', 'page_title')
            ->selectRaw('COUNT(*) as visits')
            ->selectRaw('COUNT(DISTINCT session_id) as unique_visitors')
            ->selectRaw('COUNT(DISTINCT user_id) as unique_users')
            ->where('visited_at', '>=', Carbon::now()->sub($timeframe))
            ->groupBy('url', 'page_title')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get();
    }

    /**
     * Get visitor statistics
     */
    public function getVisitorStats($startDate = null, $endDate = null): array
    {
        $query = UserJejak::query();
        
        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        } else {
            // Default last 30 days
            $query->where('visited_at', '>=', Carbon::now()->subDays(30));
        }

        $jejaks = $query->get();

        return [
            'total_page_views' => $jejaks->count(),
            'unique_visitors' => $jejaks->unique('session_id')->count(),
            'unique_users' => $jejaks->whereNotNull('user_id')->unique('user_id')->count(),
            'authenticated_sessions' => $jejaks->whereNotNull('user_id')->unique('session_id')->count(),
            'guest_sessions' => $jejaks->whereNull('user_id')->unique('session_id')->count(),
            'bounce_rate' => $this->calculateBounceRate($jejaks),
            'avg_pages_per_session' => $this->calculateAvgPagesPerSession($jejaks),
            'top_referrers' => $this->getTopReferrers($jejaks),
        ];
    }

    /**
     * Get statistik device
     */
    public function getDeviceStats($timeframe = '30 days'): Collection
    {
        return UserJejak::select('device_type')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('COUNT(DISTINCT session_id) as unique_sessions')
            ->where('visited_at', '>=', Carbon::now()->sub($timeframe))
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) {
                $item->percentage = 0; // Will be calculated
                return $item;
            });
    }

    /**
     * Get browser statistics
     */
    public function getBrowserStats($timeframe = '30 days'): Collection
    {
        return UserJejak::select('browser', 'browser_version')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('COUNT(DISTINCT session_id) as unique_sessions')
            ->where('visited_at', '>=', Carbon::now()->sub($timeframe))
            ->whereNotNull('browser')
            ->groupBy('browser', 'browser_version')
            ->orderByDesc('count')
            ->limit(10)
            ->get();
    }

    /**
     * Get daily statistics
     */
    public function getDailyStats(int $days = 30): Collection
    {
        $startDate = Carbon::now()->subDays($days)->startOfDay();
        
        return UserJejak::select(DB::raw('DATE(visited_at) as date'))
            ->selectRaw('COUNT(*) as page_views')
            ->selectRaw('COUNT(DISTINCT session_id) as unique_visitors')
            ->selectRaw('COUNT(DISTINCT user_id) as unique_users')
            ->where('visited_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get user journey
     */
    public function getUserJourney(int $userId, $timeframe = '7 days'): array
    {
        $jejaks = UserJejak::forUser($userId)
            ->where('visited_at', '>=', Carbon::now()->sub($timeframe))
            ->orderBy('visited_at', 'asc')
            ->get();

        // Group by session
        $sessions = $jejaks->groupBy('session_id');
        
        return [
            'total_sessions' => $sessions->count(),
            'total_page_views' => $jejaks->count(),
            'sessions' => $sessions->map(function ($sessionJejaks, $sessionId) {
                return [
                    'session_id' => $sessionId,
                    'start_time' => $sessionJejaks->first()->visited_at,
                    'end_time' => $sessionJejaks->last()->visited_at,
                    'duration_minutes' => $sessionJejaks->first()->visited_at->diffInMinutes($sessionJejaks->last()->visited_at),
                    'page_views' => $sessionJejaks->count(),
                    'pages' => $sessionJejaks->map(function ($jejak) {
                        return [
                            'url' => $jejak->url,
                            'page_title' => $jejak->page_title,
                            'visited_at' => $jejak->visited_at,
                            'device' => $jejak->device_type,
                            'browser' => $jejak->browser,
                        ];
                    })->toArray()
                ];
            })->values()->toArray()
        ];
    }

    /**
     * Track custom event (manual tracking)
     */
    public function track(array $data): UserJejak
    {
        return UserJejak::create(array_merge([
            'user_id' => auth()->id(),
            'session_id' => session()->getId(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'method' => request()->method(),
            'visited_at' => now(),
        ], $data));
    }

    /**
     * Get top exit pages
     */
    public function getTopExitPages(int $limit = 10, $timeframe = '30 days'): Collection
    {
        // Halaman terakhir yang dikunjungi dalam setiap session
        return DB::table('user_jejaks as uj1')
            ->select('uj1.url', 'uj1.page_title')
            ->selectRaw('COUNT(*) as exits')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('user_jejaks as uj2')
                    ->whereColumn('uj1.session_id', 'uj2.session_id')
                    ->whereColumn('uj1.visited_at', '<', 'uj2.visited_at');
            })
            ->where('uj1.visited_at', '>=', Carbon::now()->sub($timeframe))
            ->groupBy('uj1.url', 'uj1.page_title')
            ->orderByDesc('exits')
            ->limit($limit)
            ->get();
    }

    /**
     * Get real-time visitors
     */
    public function getRealTimeVisitors(): array
    {
        $fiveMinutesAgo = Carbon::now()->subMinutes(5);
        
        $activeJejaks = UserJejak::where('visited_at', '>=', $fiveMinutesAgo)
            ->get();

        return [
            'active_visitors' => $activeJejaks->unique('session_id')->count(),
            'active_users' => $activeJejaks->whereNotNull('user_id')->unique('user_id')->count(),
            'page_views_last_5min' => $activeJejaks->count(),
            'top_active_pages' => $activeJejaks->groupBy('url')
                ->map(function ($jejaks, $url) {
                    return [
                        'url' => $url,
                        'active_visitors' => $jejaks->unique('session_id')->count()
                    ];
                })
                ->sortByDesc('active_visitors')
                ->take(5)
                ->values()
                ->toArray()
        ];
    }

    /**
     * Cleanup old jejaks
     */
    public function cleanup(int $olderThanDays = 90): int
    {
        $cutoffDate = Carbon::now()->subDays($olderThanDays);
        
        return UserJejak::where('visited_at', '<', $cutoffDate)->delete();
    }

    /**
     * Calculate bounce rate
     */
    protected function calculateBounceRate(Collection $jejaks): float
    {
        $sessions = $jejaks->groupBy('session_id');
        $singlePageSessions = $sessions->filter(fn($session) => $session->count() === 1)->count();
        $totalSessions = $sessions->count();

        return $totalSessions > 0 ? round(($singlePageSessions / $totalSessions) * 100, 2) : 0;
    }

    /**
     * Calculate average pages per session
     */
    protected function calculateAvgPagesPerSession(Collection $jejaks): float
    {
        $sessions = $jejaks->groupBy('session_id');
        $totalPages = $jejaks->count();
        $totalSessions = $sessions->count();

        return $totalSessions > 0 ? round($totalPages / $totalSessions, 2) : 0;
    }

    /**
     * Get top referrers
     */
    protected function getTopReferrers(Collection $jejaks, int $limit = 5): array
    {
        return $jejaks->whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->groupBy('referrer')
            ->map(function ($group, $referrer) {
                return [
                    'referrer' => $referrer,
                    'count' => $group->count()
                ];
            })
            ->sortByDesc('count')
            ->take($limit)
            ->values()
            ->toArray();
    }
}