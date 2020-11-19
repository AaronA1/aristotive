@extends('layouts.app')

@section('content')
    <quiz questions="{{json_encode($quizArray['questions'])}}"></quiz>
@endsection
