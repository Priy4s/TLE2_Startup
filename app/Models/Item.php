<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['id', 'name', 'category', 'image', 'created_at', 'updated_at'];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

