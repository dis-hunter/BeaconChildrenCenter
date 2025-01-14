@extends('reception.layout')
@section('title','Child | Reception')
@extends('reception.header')
@section('content')

<div class="container">
    <livewire:parent-crud :parentId="$parentId"/>
</div>

@endsection