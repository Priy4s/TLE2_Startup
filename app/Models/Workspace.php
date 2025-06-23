<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CloudFile;
use App\Models\User;


class Workspace extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function cloudFiles()
    {
        return $this->belongsToMany(CloudFile::class, 'workspace_cloudfile', 'workspace_id', 'cloudfile_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}