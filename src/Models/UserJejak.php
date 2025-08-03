<?php

namespace Dewakoding\Jejak\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class UserJejak extends Model
{
    use HasFactory;

    protected $table = 'user_jejaks';

    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'url',
        'full_url',
        'method',
        'page_title',
        'referrer',
        'device_type',
        'browser',
        'browser_version',
        'platform',
        'is_mobile',
        'is_tablet',
        'is_desktop',
        'is_robot',
        'country',
        'city',
        'duration_seconds',
        'visited_at'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'duration_seconds' => 'integer',
        'is_mobile' => 'boolean',
        'is_tablet' => 'boolean',
        'is_desktop' => 'boolean',
        'is_robot' => 'boolean',
    ];

    /**
     * Relasi ke User model
     */
    public function user()
    {
        $userModel = config('auth.providers.users.model') ?: 'App\\Models\\User';
        return $this->belongsTo($userModel);
    }

    /**
     * Scope: Filter berdasarkan rentang tanggal
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('visited_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ]);
    }

    /**
     * Scope: Filter berdasarkan user tertentu
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter berdasarkan session
     */
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope: Filter berdasarkan URL/page
     */
    public function scopeForPage($query, $url)
    {
        return $query->where('url', 'like', '%' . $url . '%');
    }

    /**
     * Scope: Hanya user yang login
     */
    public function scopeAuthenticatedUsers($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope: Hanya guest/anonymous
     */
    public function scopeGuestUsers($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Scope: Filter berdasarkan device type
     */
    public function scopeByDevice($query, $deviceType)
    {
        return $query->where('device_type', $deviceType);
    }

    /**
     * Scope: Hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', Carbon::today());
    }

    /**
     * Scope: 7 hari terakhir
     */
    public function scopeLastWeek($query)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays(7));
    }

    /**
     * Scope: 30 hari terakhir
     */
    public function scopeLastMonth($query)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays(30));
    }

    /**
     * Get device icon
     */
    public function getDeviceIconAttribute()
    {
        return match($this->device_type) {
            'mobile' => '📱',
            'tablet' => '📱',
            'desktop' => '💻',
            default => '🖥️'
        };
    }

    /**
     * Get browser icon
     */
    public function getBrowserIconAttribute()
    {
        $browser = strtolower($this->browser);
        
        return match(true) {
            str_contains($browser, 'chrome') => '🔵',
            str_contains($browser, 'firefox') => '🟠',
            str_contains($browser, 'safari') => '🔘',
            str_contains($browser, 'edge') => '🔷',
            default => '🌐'
        };
    }
}