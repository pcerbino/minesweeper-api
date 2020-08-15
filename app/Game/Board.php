<?php
namespace App\Game;

use App\Enums\SquareContentType;
use App\Enums\SquareStatusType;
use App\Game\Position;

class Board {

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
        for($i = 0; $i < $rows; $i++){
            for($j=0; $j<$cols; $j++){

                $this->board[$i][$j] = new Square($j, $i, SquareContentType::fromValue(SquareContentType::Empty), SquareStatusType::fromValue(SquareStatusType::Hidden) );
            }
        }
        
        // Generate mines in random positions
        for($i=0; $i<$mines; $i++){
            $element = $this->_setRandomMine($this->board);
            $this->board[$element->y][$element->x] = $element;

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
                $board[$i][$j] = $this->board[$j][$i]->getData();
            }
        }

        return $board;
    }

    public function putFlag(Position $position){

        // Check if position is valid on the board

        // Check if position == hidden

        // Mark flag on position
        $this->board[$position->y][$position->x]->content = SquareContentType::fromValue(SquareContentType::Flag);
        $this->board[$position->y][$position->x]->status = SquareStatusType::fromValue(SquareStatusType::Visible);
    }

    public function displaySquare(Position $position){

        // TODO: Check if position is valid on the board

        // TODO: Check if position == hidden(cover)

        // Check if MINE in position
        if($this->board[$position->y][$position->x]->content->value == SquareContentType::fromValue(SquareContentType::Mine)){
            $this->_setAllSquaresVisible();
        }
            // return SquareContentType.MINE

        // Check if EMPTY
        if($this->board[$position->y][$position->x]->content->value == SquareContentType::fromValue(SquareContentType::Empty)){
            $this->_setSurroundedSquaresVisible($position);
        }

        $this->board[$position->y][$position->x]->status = SquareStatusType::fromValue(SquareStatusType::Visible);
    }


    protected function _setAllSquaresVisible(){

        for($y=0; $y < count($this->board); $y++){
            for($x=0; $x < count($this->board[$y]); $x++){

                $this->board[$y][$x]->status = SquareStatusType::fromValue(SquareStatusType::Visible);
            }
        }
    }

    protected function _setSurroundedSquaresVisible(Position $position){

        $positions = [[$position->x -1, $position->y], [$position->x, $position->y -1], [$position->x +1, $position->y], [$position->x, $position->y +1] ];

        foreach ($positions as $pos) {

            $x = $pos[0]; 
            $y = $pos[1];
            
            if( $this->_isValidPosition($x, $y) 
                && ($this->board[$y][$x]->content->value == SquareContentType::fromValue(SquareContentType::Empty) || $this->board[$y][$x]->content->value == SquareContentType::fromValue(SquareContentType::Number))
                && $this->board[$y][$x]->status->value == SquareStatusType::fromValue(SquareStatusType::Hidden))
            {
                $this->board[$y][$x]->status = SquareStatusType::fromValue(SquareStatusType::Visible);
                $nextPosition = new Position($x, $y);
                if($this->board[$y][$x]->content->value == SquareContentType::fromValue(SquareContentType::Empty))
                $this->_setSurroundedSquaresVisible($nextPosition);
            }            
        }
    }


    protected function _fillMinesSourranded(){

        for($y=0; $y < $this->rows; $y++){

            for($x=0; $x < $this->cols; $x++){

                 if($this->board[$y][$x]->content->is("mine")){

                    // left
                    $xx = $x -1; 
                    $yy = $y;
                    if($this->_isValidPosition($xx, $yy) && !$this->board[$yy][$xx]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$yy][$xx]);

                    // top left
                    $xx = $x -1; 
                    $yy = $y -1;
                    if($this->_isValidPosition($xx, $yy) && !$this->board[$yy][$xx]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$yy][$xx]);

                    // top
                    $xx = $x; 
                    $yy = $y -1;
                    if($this->_isValidPosition($xx, $yy) && !$this->board[$yy][$xx]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$yy][$xx]);

                    // top right
                    $xx = $x +1; 
                    $yy = $y -1;
                    if($this->_isValidPosition($xx, $yy) && !$this->board[$yy][$xx]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$yy][$xx]);

                    // right
                    $xx = $x + 1; 
                    $yy = $y;
                    if($this->_isValidPosition($xx, $yy) && !$this->board[$yy][$xx]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$yy][$xx]);

                    // bottom right
                    $xx = $x +1; 
                    $yy = $y +1;
                    if($this->_isValidPosition($xx, $yy) && !$this->board[$yy][$xx]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$yy][$xx]);

                    // bottom
                    $xx = $x; 
                    $yy = $y +1;
                    if($this->_isValidPosition($xx, $yy) && !$this->board[$yy][$xx]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$yy][$xx]);

                    // left bottom
                    $xx = $x -1; 
                    $yy = $y +1;
                    if($this->_isValidPosition($xx, $yy) && !$this->board[$yy][$xx]->content->is(SquareContentType::Mine))
                        $this->_sumNumber($this->board[$yy][$xx]);

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
            if($res->content = SquareContentType::fromValue(SquareContentType::Empty)){
                $res->content = SquareContentType::fromValue(SquareContentType::Mine);
                return $res;
            }else{
                return $this->_setRandomMine($array);
            }
        } 
      }
}