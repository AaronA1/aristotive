@extends('layouts.app')

@section('content')
    <admin-panel roomid="{{$room->id}}" questions="{{$questions}}"></admin-panel>
@endsection
