<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $fillable = ['name'];
    // Of als je alle velden wilt toestaan:
    // protected $guarded = [];
}