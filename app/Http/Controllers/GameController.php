<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\MoveType;
use App\Game\Game;

class GameController extends Controller
{

    protected $game;


    public function __construct(Game $game)
    {
        $this->game = $game;
    }


    public function create(Request $request)
    {

        // TODO VALIDATION

        $this->game->start(15, 15, 15);

        return response()->json(["gameId" => $this->game->id, "board" => $this->game->board->board]);
    }


    public function setSquare(Request $request, $gameId)
    {
        // TODO VALIDATION

        // TODO VALIDATION

        $x = $request->get('x');
        $y = $request->get('y');

        $this->game->set($gameId);

        $this->game->play($x, $y, MoveType::fromValue(MoveType::Show));

        return response()->json(["board" => $this->game->board->board]);
    }


    public function setFlag(Request $request, $gameId)
    {
        
        // TODO VALIDATION

        $x = $request->get('x');
        $y = $request->get('y');

        $this->game->set($gameId);

        $this->game->play($x, $y, MoveType::fromValue(MoveType::Flag));

        return response()->json(["gameId" => $this->game->id, "board" => $this->game->board->board]);
    }
}
