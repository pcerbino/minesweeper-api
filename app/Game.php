<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

	protected $fillable = [
        'status', 'started_at', 'board', 'q_cols', 'q_rows', 'q_mines'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
