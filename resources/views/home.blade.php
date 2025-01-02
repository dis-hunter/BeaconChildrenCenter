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
    <pre>{{auth()->user()->id}}</pre>
    @endauth
</div>
@endsection