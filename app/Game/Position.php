<?php
namespace App\Game;

class Position {

    /**
     * X position
     *
     * @var int
     */
    public $x;

    /**
     * Y position
     *
     * @var int
     */
    public $y;

    
    public function __construct(int $x, int $y){
        $this->x = $x;
        $this->y = $y;
    }
}