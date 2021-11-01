<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Game;
use App\Models\User;


class GamesController extends Controller
{
    public function index( Request $request )
    {
        $games = Game::all()->sortByDesc('created_at');
        $users = User::all();


        return view( 'games.index', compact( 'games', 'users' ) );
    }

    public function create( Request $request )
    {
        $game        = new Game;

        return view( 'games.create', compact( 'game') );
    }

    public function store( Request $request )
    {
        /** @var Game $game */

        $this->validate( $request, [
            'date' => 'required|date',
            'size' => 'required|integer|max:11|min:1',
        ], [], [
            'date' => 'Data da partida',
            'size' => 'Jogadores por time',
        ] );

        $dados = $request->all();

        $game = Game::create($dados);



        return redirect()->route( 'games.index' );
    }

    public function show( Game $game )
    {
        return view( 'games.show', compact( 'game' ) );
    }

    public function edit( Game $game )
    {


        $users = User::all();

        $confirmados = $game->users; 

        $confirmados;


        return view( 'games.edit', compact( 'users', 'game', 'confirmados' ) );
    }

    public function update( Request $request, Game $game )
    {

        $confirmados = $request->get('confirmation' );

        $game->users()->sync($confirmados);

        return redirect()->route( 'games.index' );
    }
}
