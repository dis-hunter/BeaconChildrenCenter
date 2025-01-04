@extends('layout')
@section('title','Homepage')
@extends('header')
@section('content')
<style>
    body {
        margin-left: 200px;
    }
</style>
<div class="container">
    @auth
    <pre>{{auth()->user()->fullname->first_name}}</pre>

    @endauth
</div>
@endsection