<?php
namespace App\Game;

use App\Enums\MoveResultType;
use Board;

class MoveResult {

    public MoveResultType $result;
    public Board $currentBoard;

    public function get(){
        
        return json_encode(['result' => $this->result, 'board' => $board]);
    }
}
