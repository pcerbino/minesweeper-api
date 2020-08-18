<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Game\Game;
use App\User;

class CreateGameTest extends TestCase
{

	public function setUp(): void
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
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
    	$data = ["rows" => 10, "cols" => 5, "mines" => 5];

    	$response = $this->post('/api/game', $data, $this->headers());

    	$response->assertOk()
    		->assertJsonCount(10, "board")
    		->assertSeeText("mine")
    		->assertSeeText("number")
    		->assertSeeText("empty")
    		->assertJsonStructure(["gameId", "board"]);
    }
}
