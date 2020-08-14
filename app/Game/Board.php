<?php
namespace App\Game;

use App\Enums\SquareContentType;
use App\Enums\SquareStatusType;
use App\Game\Position;

class Board {

    /**
     * Board.
     *
     * @var array
     */
    public array $board = [];

    public int $rows = 0;

    public int $cols = 0;

    public int $mines = 0;

    public function __construct($board = null){
        
        if($board){
            $this->board = $board;
        }
    }

    public function set($board, $rows, $cols){
        $this->board = (array) $board;
        $this->cols = $cols;
        $this->rows = $rows;

    }

    public function create(int $rows = 10, int $cols = 10, int $mines) {

        $this->cols = $cols;
        $this->rows = $rows;
        $this->mines = $mines;

        // Make array with empty values
        for($i=0; $i<$rows; $i++){
            for($j=0; $j<$cols; $j++){
                $this->board[$i][$j] = new Square($i, $j, SquareContentType::fromValue(SquareContentType::Empty), SquareStatusType::fromValue(SquareStatusType::Hidden) );
            }
        }
        
        // Generate mines in random positions
        for($i=0; $i<$mines; $i++){
            $element = $this->_setRandomMine($this->board);
            $this->board[$element->x][$element->y] = $element;
        }

        // Mark surrounded squares with numbers 
        $this->_fillMinesSourranded();


        // Return board
        return $this->board;
    }



    public function getWithVisibility(){
        
        $board = [];

        // Set all squares hidden
        for($i=0; $i<count($this->board); $i++){
            for($j=0; $j<count($this->board[0]); $j++){
                $board[$i][$j] = $this->board[$i][$j]->getData();
            }
        }

        return $board;
    }

    public function putFlag(Position $position){

        // Check if position is valid on the board

        // Check if position == hidden

        // Mark flag on position
        $this->board[$position->x][$position->y]->content = SquareContentType::fromValue(SquareContentType::Flag);
        $this->board[$position->x][$position->y]->status = SquareStatusType::fromValue(SquareStatusType::Visible);
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


    protected function _fillMinesSourranded(){

        // Make array with empty values
        for($i=0; $i < $this->rows; $i++){

            for($j=0; $j < $this->cols; $j++){

                 if($this->board[$i][$j]->content->is("mine")){

                    // left
                    if($this->_isValidPosition($i, $j-1) && !$this->board[$i][$j-1]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$i][$j-1]);

                    // left top
                    if($this->_isValidPosition($i-1, $j-1) && !$this->board[$i-1][$j-1]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$i-1][$j-1]);
                    
                    // top
                    if($this->_isValidPosition($i-1, $j) && !$this->board[$i-1][$j]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$i-1][$j]);

                    // right top
                    if($this->_isValidPosition($i-1, $j+1) && !$this->board[$i-1][$j+1]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$i-1][$j+1]);

                    // right
                    if($this->_isValidPosition($i, $j+1) && !$this->board[$i][$j+1]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$i][$j+1]);

                    // right bottom
                    if($this->_isValidPosition($i+1, $j+1) && !$this->board[$i+1][$j+1]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$i+1][$j+1]);

                    // bottom
                    if($this->_isValidPosition($i+1, $j) && !$this->board[$i+1][$j]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$i+1][$j]);

                    // left bottom
                    if($this->_isValidPosition($i+1, $j-1) && !$this->board[$i+1][$j-1]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$i+1][$j-1]);
                 }
            }
        }

    }

    protected function  _isValidPosition($x, $y) : bool {

        return ($x >= 0 && $x <= ($this->cols -1) && $y >= 0 && $y <= ($this->rows -1));
    }

    protected function _sumNumber(Square $square) : Square {

        $square->sumNumber();

        return $square;
    }

    /*
    * Avoid using rand() as described on 
    * https://stackoverflow.com/questions/21364230/php-how-to-get-random-element-from-multidimensional-array
    */
    protected function _setRandomMine($array) {
        
        $pos = rand(0,sizeof($array)-1);
        $res = $array[$pos];

        if (is_array($res)) return $this->_setRandomMine($res);
        else{
            if($res->content->is(SquareContentType::Empty)){
                $res->content = SquareContentType::fromValue(SquareContentType::Mine);
                return $res;
            }else{
                return $this->_setRandomMine($array);
            }
        } 
      }
}