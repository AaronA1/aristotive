<h1>Hello</h1>

@foreach($quizArray['questions'] as $question)
    <p>{{$question['question']}}</p>
@endforeach
