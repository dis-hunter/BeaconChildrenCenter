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
    {{auth()->user()->id}}
    @endauth
</div>
@endsection