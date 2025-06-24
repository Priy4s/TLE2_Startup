<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['workspace_id', 'content'];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
