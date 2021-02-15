@extends('layouts.app')

@section('content')
    <admin-panel room="{{$room}}" questions="{{$questions}}"></admin-panel>
@endsection
