<?php
namespace App\Game;

use App\Enums\MoveType;
use App\Enums\GameStatusType;
use App\Enums\SquareContentType;
use App\Game\Board;
use App\Game\Position;
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

    /**
     * Handles Login Request
     *
     * @param Integer $id
     */
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

    /**
     * Start game
     *
     * @param rows quantity $rows
     * @param cols quantity $cols
     * @param mines quantity $mines
     *
     * @return GameStatusType
     */
    public function start(int $rows, int $cols, int $mines) {

        $this->board->create($rows, $cols, $mines);
        $this->status = GameStatusType::fromValue(GameStatusType::New);

        $game = new $this->model;
        $game->board = json_encode($this->board->board);
        $game->user_id = auth()->user()->id;
        $game->status = $this->status;
        $game->q_rows = $this->board->rows;
        $game->q_cols = $this->board->cols;
        $game->q_mines = $this->board->mines;
        $game->save();

        $this->id = $game->id;

        return $this->status;
    }

    /**
     * Save game
     *
     * @return GameStatusType
     */
    public function save(){

        $game = $this->model->find($this->id);
        $game->board = json_encode($this->board->board);
        $game->status = $this->status;
        $game->ended_at = $this->endedAt ?? null;
        $game->started_at = $this->startedAt ?? null;
        $game->moves = $this->moves;
        $game->save();

        return $this->status;
    }

    /**
     * Play game
     *
     * @param x position on board $x
     * @param y position on board $y
     * @param MoveType
     * @return GameStatusType
     */
    public function play(int $x, int $y, MoveType $moveType) : GameStatusType {

        $this->setStartProperties();
        $this->moves++;
        
        $position = new Position($x, $y);
        
        if($moveType->is('flag')){
            $square_content = $this->board->putFlag($position);
        }

        if($moveType->is('show')){
            
            $square_content = $this->board->displaySquare($position);
            
            if($square_content->value == SquareContentType::fromValue(SquareContentType::Death) ){

                $this->loose();
            }
        }

        if($this->board->getVisibleSquares() == (($this->board->cols * $this->board->rows) - $this->board->mines)){
            $this->board->setAllSquaresVisible();
            $this->win();   
        }

        $this->save();

        return $this->status;
    }

    protected function setStartProperties(){
        
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

    protected function win(){

        $this->status = GameStatusType::fromValue(GameStatusType::Winned);
        $this->endedAt = now();
    }

}