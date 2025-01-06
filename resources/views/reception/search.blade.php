@extends('reception.layout')
@section('title','Child | Reception')
@section('content')

@livewire('child-parent-manager')


<div class="container">
    <livewire:parent-crud :parentId="$parentId"/>
</div>

@endsection