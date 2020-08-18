<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Game;
use App\User;

class DisplaySquareTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);
        $this->game = factory(Game::class)->create();
    }

    protected function headers()
    {
        $headers = ['Accept' => 'application/json'];

        if (!is_null($this->user)) {
            $token = $this->user->createToken('Token Name')->accessToken;
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }   

    public function testCreateGame()
    {
        $data = ["y" => 5, "x" => 0];

        $response = $this->put('/api/game/'.$this->game->id.'/setSquare', $data, $this->headers());

        $response->assertOk()
            ->assertJsonCount(1, "affectedSquares")
            ->assertJsonFragment(["content"=>["value"=>"number", "key"=>"Number", "description"=>"Number"]])
            ->assertJsonStructure(["gameId", "status", "affectedSquares"]);
    }
}
