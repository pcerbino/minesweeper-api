<?php
namespace App\Game;

use App\Enums\SquareContentType;
use App\Enums\SquareStatusType;
use Position;

class Board {

    /**
     * Board.
     *
     * @var array
     */
    public $board;

    public function __construct($board = null){
        
        if($board){
            $this->board = $board;
        }
    }

    public function create(int $rows = 10, int $cols = 10, int $mines){

        $this->board = [];

        // Make array with empty values
        for($i=0; $i<$rows; $i++){
            for($j=0; $j<$cols; $j++){
                $this->board[$i][$j] = new Square($i, $j, 
                                                SquareContentType::fromValue(SquareContentType::Empty), 
                                                SquareStatusType::fromValue(SquareStatusType::Hidden) );
            }
        }
        
        // Generate random mines positions
        for($i=0; $i<$mines; $i++){
            $element = $this->_getRandomElement($this->board);
            $this->board[$element->x][$element->y] = $element;
        }

        // Mark surrounded squares with numbers 


        // Return board
        return $this->board;
    }

    public function putFlag(Position $position){

        // Check if position is valid on the board

        // Check if position == hidden

        // Mark flag on position
    }

    public function putQuestionMark(Position $position){

        // Check if position is valid on the board

        // Check if position == hidden

        // Mark question Flag on position
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

    /*
    * https://stackoverflow.com/questions/21364230/php-how-to-get-random-element-from-multidimensional-array
    */

    protected function _getRandomElement($array) {
        $pos=rand(0,sizeof($array)-1);
        $res=$array[$pos];
        if (is_array($res)) return $this->_getrandomelement($res);
        else{
            if($res->content->is(SquareContentType::Empty)){
                $res->content = SquareContentType::fromValue(SquareContentType::Mine);
                return $res;
            }else{
                return $this->_getrandomelement($array);
            }
        } 
      }
}