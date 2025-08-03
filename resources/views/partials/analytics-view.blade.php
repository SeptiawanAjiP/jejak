<!-- Analytics Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Popular Pages -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Popular Pages</h3>
            <div class="space-y-3">
                @foreach($popularPages as $page)
                <div class="flex justify-between items-center">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate">{{ $page->url }}</div>
                        @if($page->page_title)
                            <div class="text-xs text-muted-foreground truncate">{{ $page->page_title }}</div>
                        @endif
                    </div>
                    <div class="text-right ml-4">
                        <div class="text-sm font-semibold">{{ number_format($page->visits) }}</div>
                        <div class="text-xs text-muted-foreground">{{ number_format($page->unique_visitors) }} unique</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Device Stats -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Device Statistics</h3>
            <div class="space-y-3">
                @foreach($deviceStats as $device)
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full mr-3 
                            @if($device->device_type === 'mobile') bg-blue-500
                            @elseif($device->device_type === 'tablet') bg-green-500
                            @elseif($device->device_type === 'desktop') bg-purple-500
                            @else bg-gray-500
                            @endif"></div>
                        <span class="text-sm font-medium capitalize">{{ $device->device_type ?: 'Unknown' }}</span>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-semibold">{{ number_format($device->count) }}</div>
                        <div class="text-xs text-muted-foreground">{{ number_format($device->unique_sessions) }} sessions</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Browser Stats -->
<div class="rounded-lg border bg-card text-card-foreground shadow-sm">
    <div class="p-6">
        <h3 class="text-lg font-semibold mb-4">Browser Statistics</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($browserStats as $browser)
            <div class="p-4 rounded-lg border">
                <div class="flex justify-between items-start mb-2">
                    <div class="font-medium">{{ $browser->browser }}</div>
                    <div class="text-sm text-muted-foreground">v{{ $browser->browser_version }}</div>
                </div>
                <div class="text-2xl font-bold mb-1">{{ number_format($browser->count) }}</div>
                <div class="text-xs text-muted-foreground">{{ number_format($browser->unique_sessions) }} unique sessions</div>
            </div>
            @endforeach
        </div>
    </div>
</div>