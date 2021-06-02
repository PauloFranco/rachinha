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

    public function edit( EditRequest $request, User $user )
    {
        $departments = Department::ordered()->get();

        return view( 'acl.users.edit', compact( 'user', 'departments' ) );
    }

    public function store( Request $request )
    {
        /** @var User $user */

        $this->validate( $request, [
            'skill' => 'required|max:1',
            'goalkeeper' => 'required|max:1',
            'email' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
        ], [], [
            'skill' => 'Habilidade',
        ] );

        $dados = $request->all();

        $user = User::create($dados);


        return redirect()->route( 'home' );
    }

    public function update( UpdateRequest $request, User $user )
    {
        $user->fill( $request->fields() )->save();

        Toastr::success( 'Usuário atualizado com sucesso' );

        return redirect()->route( 'acl.users.index' );
    }

    public function destroy( DestroyRequest $request, User $user )
    {
        $user->destroy_user_id = $request->authUser()->id;

        $user->save();

        $user->delete();

        Toastr::success( 'Usuário removido com sucesso' );

        return redirect()->back();
    }
}
