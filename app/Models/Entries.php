<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    protected $table = 'entries';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
