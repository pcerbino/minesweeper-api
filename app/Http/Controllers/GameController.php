<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Game\Game;
use App\Enums\MoveType;
use App\Http\Requests\GameCreateRequest;
use App\Http\Requests\SetSquareRequest;
use App\Http\Requests\SetFlagRequest;

class GameController extends Controller
{

    protected $game;


    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function create(GameCreateRequest $request)
    {

        $validated = $request->validated();

        $rows = $request->get('rows');
        $cols = $request->get('cols');
        $mines = $request->get('mines');

        $this->game->start($rows, $cols, $mines);

        return response()->json(["gameId" => $this->game->id, "board" => $this->game->board->board]);
    }

    public function setSquare(SetSquareRequest $request, $gameId)
    {

        $validated = $request->validated();

        $x = $request->get('x');
        $y = $request->get('y');

        $this->game->set($gameId);

        $status = $this->game->play($x, $y, MoveType::fromValue(MoveType::Show));

        return response()->json(["gameId" => $this->game->id, "status" => $status->value, "affectedSquares" => $this->game->board->affectedSquares]);
    }


    public function setFlag(SetFlagRequest $request, $gameId)
    {

        $x = $request->get('x');
        $y = $request->get('y');

        $this->game->set($gameId);

        $status = $this->game->play($x, $y, MoveType::fromValue(MoveType::Flag));

        return response()->json(["gameId" => $this->game->id, "status" => $status->value, "affectedSquares" => $this->game->board->affectedSquares]);
    }

}