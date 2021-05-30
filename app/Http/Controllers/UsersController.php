<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Helpers\Toastr;


class UsersController extends Controller
{
    public function index( Request $request )
    {
        $search = value_or_null( $request->query( 'search', false ) );

        $users = User::withTrashed()
            ->search( $search )
            ->ordered()
            ->appends( [ 'search' => $search ?: '' ] );

        return view( 'users.index', compact( 'users', 'search' ) );
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

        $dados = $request->all();

        $user = User::create($dados);

        // 8 == Operação / Hora-a-Hora

        Toastr::success( 'Usuário criado com sucesso' );

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
