<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['workspace_id', 'url', 'label'];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
