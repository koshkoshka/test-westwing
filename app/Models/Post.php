<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected static $unguarded = true;
    
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
