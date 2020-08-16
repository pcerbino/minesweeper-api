<?php
namespace App\Game;

use App\Enums\MoveType;
use App\Enums\GameStatusType;
use App\Enums\SquareContentType;
use App\Game\Board;
use App\Game\   Position;
use App\Game as GameModel;

class Game {

    /**
     * Game status type
     */
    public GameStatusType $status;

    /**
     * Move type
     */
    public MoveType $moveType;

    /**
     * Game id
     * 
     * @var int
     */
    public $id;

    /**
     * User player
     * 
     * @var int
     */
    public $user;
    
    /**
     * Game board
     * 
     * @var json
     */
    public $board;       

    /**
     * Game started at
     * 
     * @var DateTime
     */
    public $startedAt;

    /**
     * Game Model
     * 
     * @var Game Model
     */
    public $model;

    /**
     * Game ended at time 
     * 
     * @var DateTime
     */
    public $endedAt;

    /**
     * Moves realized on game 
     * 
     * @var int
     */
    public $moves;


    public function __construct(Board $board, GameModel $model){

        $this->board = $board;
        $this->model = $model;
    }

    public function set(int $id){

        $game = $this->model->find($id);

        $this->id   = $game->id;

        $this->board->board = json_decode($game->board);
        $this->board->rows = $game->q_rows;
        $this->board->cols = $game->q_cols;
        $this->board->mines = $game->q_mines;
        $this->moves = $game->moves;
        $this->startedAt = $game->started_at;
        $this->status = GameStatusType::fromValue($game->status);
    }


    public function start(int $rows, int $cols, int $mines) {

        // Create new board with size and mines
        $this->board->create($rows, $cols, $mines);

        // Set NEW status
        $this->status = GameStatusType::fromValue(GameStatusType::New);

        // Create new record on DB
        $game = new $this->model;
        $game->board = json_encode($this->board->board);
        $game->user_id = 1;
        $game->status = $this->status;
        $game->q_rows = $this->board->rows;
        $game->q_cols = $this->board->cols;
        $game->q_mines = $this->board->mines;
        $game->save();

        $this->id = $game->id;

        return true;
    }

    public function save(){

        $game = $this->model->find($this->id);
        $game->board = json_encode($this->board->board);
        $game->status = $this->status;
        $game->ended_at = $this->endedAt ?? null;
        $game->started_at = $this->startedAt ?? null;
        $game->moves = $this->moves;
        $game->save();
    }

    public function play(int $x, int $y, MoveType $moveType) : GameStatusType {

        $this->setStartProps();
        $this->moves++;
        
        $position = new Position($x, $y);
        
        if($moveType->is('flag')){
            $square_content = $this->board->putFlag($position);
        }

        if($moveType->is('show')){
            $square_content = $this->board->displaySquare($position);
        }

        if($square_content->value == SquareContentType::fromValue(SquareContentType::Death) ){
            $this->loose();
        }

        $this->save();

        return $this->status;
    }

    protected function setStartProps(){
        
        if($this->startedAt === null){
            $this->status = GameStatusType::fromValue(GameStatusType::InProgress);
            $this->startedAt = now();
        }

        return $this->startedAt;
    }


    protected function loose(){

        $this->status = GameStatusType::fromValue(GameStatusType::Loosed);
        $this->endedAt = now();
    }

}