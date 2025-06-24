<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendars';
    protected $fillable = ['event', 'date', 'user_id', 'workspace_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
        return $this->belongsTo(Workspace::class);
    }
}