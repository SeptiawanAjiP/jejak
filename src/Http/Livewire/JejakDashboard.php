<?php

namespace Dewakoding\Jejak\Http\Livewire;

use Livewire\Component;
use Dewakoding\Jejak\Facades\Jejak;
use Carbon\Carbon;

class JejakDashboard extends Component
{
    public function render()
    {
        // Use default last 7 days
        $startDate = now()->subDays(7)->startOfDay();
        $endDate = now()->endOfDay();

        // Statistics using Jejak Facade
        $stats = Jejak::getVisitorStats($startDate, $endDate);
        $popularPages = Jejak::getPopularPages(10, '7 days');
        $deviceStats = Jejak::getDeviceStats('7 days');
        $browserStats = Jejak::getBrowserStats('7 days');
        $dailyStats = Jejak::getDailyStats(7);
        
        // Additional data for enhanced dashboard
        $realTimeData = Jejak::getRealTimeVisitors();
        $topExitPages = Jejak::getTopExitPages(5, '7 days');
        $topReferrers = $stats['top_referrers'] ?? [];
        $avgPagesPerSession = $stats['avg_pages_per_session'] ?? 0;
        $authenticatedSessions = $stats['authenticated_sessions'] ?? 0;
        $guestSessions = $stats['guest_sessions'] ?? 0;

        return view('jejak::jejak-dashboard', compact(
            'stats',
            'popularPages',
            'deviceStats',
            'browserStats',
            'dailyStats',
            'realTimeData',
            'topExitPages',
            'topReferrers',
            'avgPagesPerSession',
            'authenticatedSessions',
            'guestSessions'
        ))->layout('jejak::layouts.app');
    }
}