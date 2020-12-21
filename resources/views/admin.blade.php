@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('room.create') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="roomId" class="col-md-4 col-form-label text-md-right">Room ID</label>

                            <div class="col-md-6">
                                <input id="roomId" type="text" class="form-control" name="roomId" required
                                       autofocus>

                                @error('roomId')
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
    </div>
</div>
@endsection
