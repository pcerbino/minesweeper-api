<?php
namespace App\Game;

use App\Enums\SquareContentType;
use Position;

class Board {

    /**
     * Board.
     *
     * @var array
     */
    protected $board;

    public function __construct($board = null){
        
        if($board){
            $this->board = $board;
        }
    }

    public function create(int $rows = 10, int $cols = 10, int $mines){

        // Make array with empty values
        
        // Generate random mines positions

        // Put mines into array
        
        // Mark surrounded squares with numbers 

        // Return board
    }

    public function putFlag(Position $position){

        // Check if position is valid on the board

        // Check if position == hidden

        // Mark flag on position
    }

    public function displaySquare(Position $position) : SquareContentType{

        // Check if position is valid on the board

        // Check if position == hidden(cover)

        // Check if MINE in position
            // Set all squares displayed
            // return SquareContentType.MINE

        // Check if NUMBER 
            // Set square visible
            // return SquareContentType.NUMBER

        // Check if EMPTY
            // Set sourranded squares visible
            // return SquareContentType.EMPTY
    }

    protected function _setSquareVisible(Position $position = null){

    }

    protected function _setAllSquaresVisible(){

        //foreach Square in BOARD
            // setSquareVisible
    }

    protected function _setSourrandedVisible(Position $position){
        
    }
}