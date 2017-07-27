@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Add a Lifeline</h3></div>

                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/lines">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Name:</label>
                                <input type="text" class="form-control" id="name" name="name"  value="{{ old('name') }}" placeholder="Line name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Line</button>
                            <a class="btn btn-default" href="{{ URL::previous() }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
