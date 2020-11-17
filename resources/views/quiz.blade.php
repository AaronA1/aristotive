@extends('layouts.app')

@section('content')
    <h1>Hello</h1>
    <example-component></example-component>
    @foreach($quizArray['questions'] as $question)
        <p>{{$question['question']}}</p>
    @endforeach
@endsection
