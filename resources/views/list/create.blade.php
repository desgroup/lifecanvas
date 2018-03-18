@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Add a Lifelist</h3></div>
                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/lists">
                            {{ csrf_field() }}
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="List name" required autofocus>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="privacy">Privacy</label>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy1" value="0" {{ old("privacy", Auth::user()->privacy) == 0 ? "checked":"" }}>
                                            Myself only
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy2" value="1" {{ old("privacy", Auth::user()->privacy) == 1 ? "checked":"" }}>
                                            My Friends
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy3" value="2" {{ old("privacy", Auth::user()->privacy) == 2 ? "checked":"" }}>
                                            The World
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class='row form-group'>
                                <button type="submit" class="btn btn-raised btn-primary">Add List</button>
                                <a class="btn btn-default" href="{{ URL::previous() }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
