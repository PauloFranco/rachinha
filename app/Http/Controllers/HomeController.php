<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Match;
use App\Models\User;

class HomeController extends Controller
{
    //TODO
    //Index
    public function index()
    {
        $users = User::all();

        return view('home', compact('users'));
    }
}
