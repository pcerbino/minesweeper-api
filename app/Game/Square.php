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

    public function __construct(int $x, int $y, SquareContentType $content, SquareStatusType $status){
        $this->position = [$x, $y];
        $this->y = $y;
        $this->x = $x;
        $this->content = $content;
        $this->status = $status;
    }
}