<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;


class UsersController extends Controller
{
    public function index( Request $request )
    {
        $users = User::all();


        return view( 'users.index', compact( 'users' ) );
    }

    public function show( User $user )
    {
        $user->load( [ 'department', 'roles', 'permissions' ] );

        return view( 'acl.users.show', compact( 'user' ) );
    }

    public function create( Request $request )
    {
        $user        = new User;

        return view( 'users.create', compact( 'user') );
    }

    public function store( Request $request )
    {
        /** @var User $user */

        $this->validate( $request, [
            'skill' => 'required|integer|min:1|max:5',
            'goalkeeper' => 'required|integer|min:0|max:1',
            'name' => 'required|max:255',
        ], [], [
            'skill' => 'Habilidade',
        ] );

        $dados = $request->all();

        $user = User::create($dados);


        return redirect()->route( 'users.index' );
    }

}
