<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userResults extends Model
{
    protected $fillable = ['user_id', 'user_name', 'film_title', 'score'];
}
