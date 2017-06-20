@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add a Byte</div>

                    <div class="panel-body">
                        <form method="POST" action="/bytes">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Byte title">
                            </div>
                            <div class="form-group">
                                <label for="story">Story:</label>
                                <textarea name="story" id="story" class="form-control"
                                          placeholder="Add a story or notes here" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Byte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
