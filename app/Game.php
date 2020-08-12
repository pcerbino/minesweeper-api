<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    
    protected $attributes = [
        'status' => 'new',
        'result' => 'not_finish',
        'started_at' => date()
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}