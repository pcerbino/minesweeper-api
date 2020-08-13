<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Game\Game;

class GameController extends Controller
{

    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $board = $this->game->start(20, 20, 5);

        var_dump( json_encode($board, JSON_FORCE_OBJECT));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $gameId
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, $gameId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
