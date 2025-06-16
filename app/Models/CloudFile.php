<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CloudFile extends Model
{
    use HasFactory;
    protected $table = 'cloud_drive_files';

    protected $fillable = [
        'user_id',
        'provider',       // 'google' or 'microsoft'
        'file_id',
        'name',
        'mime_type',
        'web_view_link',
        'synced_at',
    ];

    protected $casts = [
        'synced_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes for convenience
    public function scopeFromGoogle($query)
    {
        return $query->where('provider', 'google');
    }

    public function scopeFromMicrosoft($query)
    {
        return $query->where('provider', 'microsoft');
    }

    public function scopeRecentlySynced($query, $minutes = 10)
    {
        return $query->where('synced_at', '>=', now()->subMinutes($minutes));
    }
}
