<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Project extends Model
{
    protected $fillable = [
        'name','thumbnail'
    ];

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
