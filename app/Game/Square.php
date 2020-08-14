<?php
namespace App\Game;

use App\Enums\SquareContentType;
use App\Enums\SquareStatusType;

class Square {

    /**
     * Square content types
     */
    public SquareContentType $content;

    /**
     * Square status types
     */
    public SquareStatusType $status;

    /**
     * Position
     */
    public $position;

    /**
     * Position X
     */
    public $x;

    /**
     * Position Y
     */
    public $y;

    /**
     * Number of surrounded mines
     */
    public $number = 0;

    public function __construct(int $x, int $y, SquareContentType $content, SquareStatusType $status){
        $this->position = [$x, $y];
        $this->y = $y;
        $this->x = $x;
        $this->content = $content;
        $this->status = $status;
    }

    public function getData(){
       
       if($this->status == SquareStatusType::fromValue(SquareStatusType::Hidden)){
        return $this->_returnHiddenData(); 
       }

       if($this->status == SquareStatusType::fromValue(SquareStatusType::Visible)){
        return $this->_returnVisibleData(); 
       }
    }

    public function sumNumber(){
        $this->content = SquareContentType::fromValue(SquareContentType::Number);
        $this->number++;
    }

    public function _returnHiddenData() : array {

        return ['position' => $this->position, 'status' => $this->status];
    }

    public function _returnVisibleData(){
        return ['position' => $this->position, 'status' => $this->status, 'content' => $this->content, 'number' => $this->number];
    }
}