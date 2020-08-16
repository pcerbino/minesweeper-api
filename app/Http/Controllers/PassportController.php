<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Game;
use Illuminate\Http\Request;
 
class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('minesweeperbestgame')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('minesweeperbestgame')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {

        $qGames = Game::where('user_id', auth()->user()->id)->where('status', '<>', 'new')->count();

        $qGamesLoosed = Game::where('user_id', auth()->user()->id)->where('status', 'loosed')->count();
        $qGamesWinned = Game::where('user_id', auth()->user()->id)->where('status', 'winned')->count();
        $qGamesInProgress = Game::where('user_id', auth()->user()->id)->where('status', 'in_progress')->count();
        $lastGame = Game::where('user_id', auth()->user()->id)->latest('id')->first();
        $qGamesAbandoned = 0;
        $qGamesInProgress = 0;
        
        if(!empty($lastGame)){
            $qGamesAbandoned = Game::where('user_id', auth()->user()->id)->whereIn('status', ['in_progress'])->where('id', '<', $lastGame->id)->count();
            $qGamesInProgress = Game::where('user_id', auth()->user()->id)->whereIn('status', ['in_progress'])->where('id', $lastGame->id)->count();    
        }
    
        return response()->json(['user' => auth()->user(), 'stats' => ['played' => $qGames, 'loosed' => $qGamesLoosed, 'winned' => $qGamesWinned, 'abandoned' => $qGamesAbandoned, 'inProgress' => $qGamesInProgress]], 200);
    }
}