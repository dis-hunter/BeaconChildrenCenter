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
    @php
    function printArray($array, $prefix = '') {
    foreach ($array as $key => $value) {
    if (is_array($value)) {
    echo $prefix . $key . ": <br>";
    printArray($value, $prefix . '&nbsp;&nbsp;&nbsp;'); // Indent nested values
    } else {
    echo $prefix . $key . ": " . htmlspecialchars($value) . "<br>";
    }
    }
    }
    @endphp

    @php printArray(auth()->user()->toArray()) @endphp
    @endauth
</div>
@endsection