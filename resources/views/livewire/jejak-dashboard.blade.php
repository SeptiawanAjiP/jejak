<div class="min-h-screen bg-background">
    <!-- Header -->
    <div class="border-b">
        <div class="container mx-auto px-4 py-4 md:py-6">
            <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                <div class="text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Jejak Analytics</h1>
                    <p class="text-sm md:text-base text-muted-foreground mt-1">Monitor your website activity and visitor tracking</p>
                </div>
                
                <!-- View Mode Toggle -->
                <div class="flex items-center justify-center md:justify-end">
                    <div class="inline-flex rounded-lg border p-1">
                        <button 
                            wire:click="setViewMode('dashboard')"
                            class="inline-flex items-center justify-center rounded-md px-2 md:px-3 py-2 text-xs md:text-sm font-medium transition-all {{ $viewMode === 'dashboard' ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}"
                        >
                            <svg class="mr-1 md:mr-2 h-3 w-3 md:h-4 md:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="hidden sm:inline">Dashboard</span>
                        </button>
                        <button 
                            wire:click="setViewMode('analytics')"
                            class="inline-flex items-center justify-center rounded-md px-2 md:px-3 py-2 text-xs md:text-sm font-medium transition-all {{ $viewMode === 'analytics' ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}"
                        >
                            <svg class="mr-1 md:mr-2 h-3 w-3 md:h-4 md:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="hidden sm:inline">Analytics</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-4 md:py-6">
        <!-- Filters Card -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm mb-6">
            <div class="p-4 md:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Period</label>
                        <select wire:model.live="dateRange" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="1">Last 1 Day</option>
                            <option value="7">Last 7 Days</option>
                            <option value="30">Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Filter URL</label>
                        <input wire:model.live.debounce.300ms="filterUrl" type="text" placeholder="Search URL..." 
                               class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Device</label>
                        <select wire:model.live="filterDevice" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="">All Devices</option>
                            <option value="mobile">Mobile</option>
                            <option value="tablet">Tablet</option>
                            <option value="desktop">Desktop</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <label class="flex items-center space-x-2">
                            <input wire:model.live="showOnlyMyJejak" type="checkbox" 
                                   class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground">
                            <span class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Only my tracks</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        @if($viewMode === 'dashboard')
            @include('jejak::partials.dashboard-view')
        @else
            @include('jejak::partials.analytics-view')
        @endif
    </div>
</div>