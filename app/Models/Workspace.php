<?php

namespace App\Models;

use App\Models\CloudFile;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Workspace extends Model
{
    protected $fillable = ['name'];
    // Of als je alle velden wilt toestaan:
    // protected $guarded = [];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function cloudFiles()
    {
        return $this->belongsToMany(CloudFile::class, 'workspace_cloudfile', 'workspace_id', 'cloudfile_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}