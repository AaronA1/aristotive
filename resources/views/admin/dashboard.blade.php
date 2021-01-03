@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Start a new quiz room</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('room.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="quizDir" class="col-md-4 col-form-label text-md-right">Quiz Directory</label>

                                <div class="col-md-6">
                                    <input id="quizDir" type="text" class="form-control @error('quizDir') is-invalid @enderror"
                                           name="quizDir" value="{{ old('quizDir') }}" required autofocus>

                                    @error('quizDir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create Room
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Current Rooms</div>

                    <div class="card-body">
                        @foreach($rooms as $room)
                            <div class="row">
                                <h1>{{$room->id}}</h1>
                                <button><a href="{{route('session', $room->id)}}">Enter Room</a></button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
