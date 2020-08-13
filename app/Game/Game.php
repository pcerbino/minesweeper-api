<?php
namespace App\Game;

use App\Enums\MoveType;
use App\Enums\GameStatusType;
use App\Game\Board;

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


    public function __construct(Board $board){

        $this->board = $board;
    }

    public function start(int $rows, int $cols, int $mines) : Board {

        // Create new board with size and mines
        $this->board->create($rows, $cols, $mines);

        // Set NEW status

        // Create new record on DB
        
        // Return board

        return $this->board;
    }

    public function makeMove($position, $moveType) : MoveResult {

        // Check game status

        // CASE MoveType

            // FLAG
                // Board > putFlag

            // QUESTION MARK
                // Board > putQuestionMark

            // Display
                // Board > display
                    // Result == Bomb
                        // Finish game

        
        // Update DB record
        // Set MoveResult 
        // Return MoveResult
    }

}