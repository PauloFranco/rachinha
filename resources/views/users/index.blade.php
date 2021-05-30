@extends('layouts.app')

@section('title', make_title('Usuários'))

@section('header')

@endsection

@section('content')
<ul>
    @foreach ($users as $user)
    <li>{{$user->name}}</li>
    @endforeach
</ul>
@endsection