<?php
namespace App\Game;

use App\Enums\MoveType;
use App\Enums\GameStatusType;
use Board;

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


    public function __construct($game = null){
        if($game){
            // Set vars
        }
    }

    public function start(integer $qMines, integer $qRows, integer $qCols) : Board {

        // Create new board with size and mines

        // Set NEW status

        // Create new record on DB
        
        // Return board
    }

    public function makeMove($position, $moveType) : MoveResult {

        // Check game status

        // CASE MoveType

            // FLAG
                // Board > putFlag

            // Display
                // Board > display
                    // Result == Bomb
                        // Finish game

        
        // Update DB record
        // Set MoveResult 
        // Return MoveResult
    }

}