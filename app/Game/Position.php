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

    /**
     * Mine
     *
     * @var int
     */
    public $y;
    
    public function set(integer $x, integer $i){
        $this->x = $x;
        $this->y = $y;
    }
}