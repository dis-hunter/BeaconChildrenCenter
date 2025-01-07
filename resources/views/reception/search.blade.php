@extends('reception.layout')
@section('title','Child | Reception')
@extends('reception.header')
@section('content')

@livewire('child-parent-manager')


<div class="container">
    <livewire:parent-crud :parentId="$parentId"/>
</div>

@endsection