<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-8">
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8 flex flex-row items-center justify-between space-y-0 pb-3">
            <h3 class="tracking-tight text-sm font-medium">Total Page Views</h3>
            <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
        </div>
        <div class="p-6 lg:p-8 pt-0">
            <div class="text-2xl lg:text-3xl font-bold">{{ number_format($stats['total_page_views']) }}</div>
            <p class="text-sm text-muted-foreground mt-1">Total page visits</p>
        </div>
    </div>
    
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8 flex flex-row items-center justify-between space-y-0 pb-3">
            <h3 class="tracking-tight text-sm font-medium">Unique Visitors</h3>
            <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
        </div>
        <div class="p-6 lg:p-8 pt-0">
            <div class="text-2xl lg:text-3xl font-bold">{{ number_format($stats['unique_visitors']) }}</div>
            <p class="text-sm text-muted-foreground mt-1">Unique visitors</p>
        </div>
    </div>
    
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8 flex flex-row items-center justify-between space-y-0 pb-3">
            <h3 class="tracking-tight text-sm font-medium">Unique Users</h3>
            <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div class="p-6 lg:p-8 pt-0">
            <div class="text-2xl lg:text-3xl font-bold">{{ number_format($stats['unique_users']) }}</div>
            <p class="text-sm text-muted-foreground mt-1">Registered users</p>
        </div>
    </div>
    
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8 flex flex-row items-center justify-between space-y-0 pb-3">
            <h3 class="tracking-tight text-sm font-medium">Bounce Rate</h3>
            <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <div class="p-6 lg:p-8 pt-0">
            <div class="text-2xl lg:text-3xl font-bold">{{ number_format($stats['bounce_rate'], 1) }}%</div>
            <p class="text-sm text-muted-foreground mt-1">Bounce rate</p>
        </div>
    </div>
</div>

<!-- Real-time Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-8">
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8 flex flex-row items-center justify-between space-y-0 pb-3">
            <h3 class="tracking-tight text-sm font-medium">Active Visitors</h3>
            <div class="h-3 w-3 bg-green-500 rounded-full animate-pulse"></div>
        </div>
        <div class="p-6 lg:p-8 pt-0">
            <div class="text-2xl lg:text-3xl font-bold">{{ number_format($realTimeData['active_visitors']) }}</div>
            <p class="text-sm text-muted-foreground mt-1">Last 5 minutes</p>
        </div>
    </div>
    
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8 flex flex-row items-center justify-between space-y-0 pb-3">
            <h3 class="tracking-tight text-sm font-medium">Avg Pages/Session</h3>
            <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <div class="p-6 lg:p-8 pt-0">
            <div class="text-2xl lg:text-3xl font-bold">{{ number_format($avgPagesPerSession, 1) }}</div>
            <p class="text-sm text-muted-foreground mt-1">Pages per session</p>
        </div>
    </div>
    
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8 flex flex-row items-center justify-between space-y-0 pb-3">
            <h3 class="tracking-tight text-sm font-medium">Authenticated Sessions</h3>
            <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div class="p-6 lg:p-8 pt-0">
            <div class="text-2xl lg:text-3xl font-bold">{{ number_format($authenticatedSessions) }}</div>
            <p class="text-sm text-muted-foreground mt-1">Logged in users</p>
        </div>
    </div>
    
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8 flex flex-row items-center justify-between space-y-0 pb-3">
            <h3 class="tracking-tight text-sm font-medium">Guest Sessions</h3>
            <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="p-6 lg:p-8 pt-0">
            <div class="text-2xl lg:text-3xl font-bold">{{ number_format($guestSessions) }}</div>
            <p class="text-sm text-muted-foreground mt-1">Anonymous visitors</p>
        </div>
    </div>
</div>

<!-- Daily Stats Chart -->
<div class="rounded-lg border bg-card text-card-foreground shadow-sm mb-8">
    <div class="p-6 lg:p-8">
        <h3 class="text-lg font-semibold mb-6">Daily Traffic (Last 7 Days)</h3>
        <div class="space-y-4">
            @forelse($dailyStats as $day)
            <div class="flex items-center justify-between py-2">
                <div class="flex-1 min-w-0 pr-4">
                    <div class="text-sm font-medium">{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</div>
                    <div class="text-xs text-muted-foreground">{{ \Carbon\Carbon::parse($day->date)->format('l') }}</div>
                </div>
                <div class="flex space-x-4 text-sm">
                    <span class="font-medium">{{ number_format($day->page_views) }} views</span>
                    <span class="text-muted-foreground">{{ number_format($day->unique_visitors) }} visitors</span>
                </div>
            </div>
            @empty
            <div class="text-center text-muted-foreground py-8">
                No data available
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Popular Pages & Top Referrers -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 mb-8">
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8">
            <h3 class="text-lg font-semibold mb-6">Popular Pages</h3>
            <div class="space-y-4">
                @forelse($popularPages as $page)
                <div class="flex items-center justify-between py-2">
                    <div class="flex-1 min-w-0 pr-4">
                        <div class="text-sm font-medium truncate">{{ $page->url }}</div>
                        @if($page->page_title)
                            <div class="text-xs text-muted-foreground truncate mt-1">{{ $page->page_title }}</div>
                        @endif
                    </div>
                    <div class="text-sm font-medium">{{ number_format($page->visits) }} views</div>
                </div>
                @empty
                <div class="text-center text-muted-foreground py-8">
                    No data available
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Referrers -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8">
            <h3 class="text-lg font-semibold mb-6">Top Referrers</h3>
            <div class="space-y-4">
                @forelse($topReferrers as $referrer)
                <div class="flex items-center justify-between py-2">
                    <div class="flex-1 min-w-0 pr-4">
                        <div class="text-sm font-medium truncate">{{ parse_url($referrer['referrer'], PHP_URL_HOST) ?: 'Direct' }}</div>
                        <div class="text-xs text-muted-foreground truncate mt-1">{{ $referrer['referrer'] }}</div>
                    </div>
                    <div class="text-sm font-medium">{{ number_format($referrer['count']) }}</div>
                </div>
                @empty
                <div class="text-center text-muted-foreground py-8">
                    No referrer data available
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Device Stats & Exit Pages -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 mb-8">
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8">
            <h3 class="text-lg font-semibold mb-6">Device Types</h3>
            <div class="space-y-4">
                @forelse($deviceStats as $device)
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-center space-x-3">
                        <span class="text-sm font-medium">{{ ucfirst($device->device_type ?: 'Unknown') }}</span>
                    </div>
                    <div class="text-sm font-medium">{{ $device->count }}</div>
                </div>
                @empty
                <div class="text-center text-muted-foreground py-8">
                    No data available
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Exit Pages -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 lg:p-8">
            <h3 class="text-lg font-semibold mb-6">Top Exit Pages</h3>
            <div class="space-y-4">
                @forelse($topExitPages as $exitPage)
                <div class="flex items-center justify-between py-2">
                    <div class="flex-1 min-w-0 pr-4">
                        <div class="text-sm font-medium truncate">{{ $exitPage->url }}</div>
                        @if($exitPage->page_title)
                            <div class="text-xs text-muted-foreground truncate mt-1">{{ $exitPage->page_title }}</div>
                        @endif
                    </div>
                    <div class="text-sm font-medium">{{ number_format($exitPage->exits) }} exits</div>
                </div>
                @empty
                <div class="text-center text-muted-foreground py-8">
                    No exit data available
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Browser Stats -->
<div class="rounded-lg border bg-card text-card-foreground shadow-sm">
    <div class="p-6 lg:p-8">
        <h3 class="text-lg font-semibold mb-6">Browser Usage</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($browserStats as $browser)
            <div class="flex items-center justify-between p-4 rounded-lg bg-muted">
                <span class="text-sm font-medium truncate pr-2">{{ $browser->browser ?: 'Unknown' }}</span>
                <span class="text-sm font-medium">{{ $browser->count }}</span>
            </div>
            @empty
            <div class="col-span-full text-center text-muted-foreground py-8">
                No data available
            </div>
            @endforelse
        </div>
    </div>
</div>
