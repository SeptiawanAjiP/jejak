# Jejak - Laravel User Tracking Package

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-9%2B-red.svg)](https://laravel.com)

A Laravel package for tracking user behavior and website analytics.

## Features

- 📊 Real-time analytics dashboard
- 👤 User & guest tracking
- 📱 Device & browser detection
- 📈 Popular pages & exit pages
- 🔗 Referrer tracking
- 🤖 Bot filtering
- 🧹 Auto cleanup

## Installation

```bash
composer require dewakoding/jejak
php artisan vendor:publish --tag=jejak-migrations
php artisan vendor:publish --tag=jejak-config
php artisan migrate
```

## Usage

### Add Middleware

```php
// routes/web.php
Route::middleware(['jejak'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/about', [AboutController::class, 'index']);
});
```

### Access Dashboard

Visit: `http://your-app.com/jejak`

### Using Facade

```php
use Dewakoding\Jejak\Facades\Jejak;

// Get visitor statistics
$stats = Jejak::getVisitorStats();

// Get popular pages
$popularPages = Jejak::getPopularPages(10);

// Get device statistics
$deviceStats = Jejak::getDeviceStats();

// Get real-time visitors
$realTime = Jejak::getRealTimeVisitors();
```

## Configuration

Edit `config/jejak.php`:

```php
return [
    'enabled' => env('JEJAK_ENABLED', true),
    'skip_ajax' => env('JEJAK_SKIP_AJAX', false),
    'skip_routes' => ['api/*', 'admin/*'],
    'skip_ips' => ['127.0.0.1'],
    'route' => [
        'prefix' => 'jejak',
        'middleware' => ['web', 'auth'],
    ],
];
```

## Environment Variables

```env
JEJAK_ENABLED=true
JEJAK_SKIP_AJAX=false
JEJAK_LOG_ERRORS=true
```

## Auto Cleanup

```bash
# Manual cleanup
php artisan jejak:cleanup

# Schedule in app/Console/Kernel.php
$schedule->command('jejak:cleanup')->daily();
```

## License

MIT License

## Author

**Septiawan Aji Pradana**  
Email: dev.dewakoding@gmail.com