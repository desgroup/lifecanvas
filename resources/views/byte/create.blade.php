@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Add a Byte</h3></div>

                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/bytes">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Byte title">
                            </div>
                            <div class="form-group">
                                <label for="story">Story:</label>
                                <textarea name="story" id="story" class="form-control"
                                          placeholder="Add a story or notes here" rows="4">{{ old('story') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="privacy">Privacy:</label>
                                <select class="form-control" id="privacy" name="privacy" value="{{ old('privacy') }}">
                                    <option value="0" {{ old("privacy") == 0 ? "selected":"" }}>Myself only</option>
                                    <option value="1" {{ old("privacy") == 1 ? "selected":"" }}>My Friends</option>
                                    <option value="2" {{ old("privacy") == 2 ? "selected":"" }}>The World</option>
                                </select>
                            </div>
                            {{ old("lines->id") }}
                            <div class="form-group">
                                <label for="story">Lifeline:</label>
                                <select class="form-control" multiple="multiple" name="lines[]" id="lines" class="form-control" >
                                    @foreach($mylines as $line)
                                        <option value="{{ $line->id }}" {{ (collect(old('lines'))->contains($line->id)) ? 'selected':'' }}>{{ $line->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='form-group'>
                                <button type="submit" class="btn btn-primary">Add Byte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
