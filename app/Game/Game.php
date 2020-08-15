<?php
namespace App\Game;

use App\Enums\MoveType;
use App\Enums\GameStatusType;
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
     * Game ended at
     * 
     * @var DateTime
     */
    public $endedAt;

    public $model;


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
        $game->save();
    }

    public function play(int $x, int $y, MoveType $moveType) {

        // Check game status

        // CASE MoveType
            // FLAG
                // Board > putFlag

        if($moveType->is('flag')){
            
            $position = new Position($x, $y);

            $this->board->putFlag($position);
            $this->save();
        }

        if($moveType->is('show')){
            ;
            $position = new Position($x, $y);

            $this->board->displaySquare($position);
            $this->save();
        }


            // QUESTION MARK
                // Board > putQuestionMark

            // Display
                // Board > display
                    // Result == Bomb
                        // Finish game


        return true;
    }


}