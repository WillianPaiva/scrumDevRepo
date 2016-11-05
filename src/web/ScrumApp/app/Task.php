<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function UserStory()
    {
        return $this->belongsTo('App\UserStory');
    }
}
