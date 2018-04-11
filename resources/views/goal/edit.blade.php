@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Edit a Goal</h3></div>
                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/goals/{{ $goal->id }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <div class="row form-group">
                                <!-- Image File -->
                                <div class="col-md-12">
                                    <label class="control-label" for="image">Image</label>
                                    @if($agent->isMobile() || $agent->isTablet())
                                        <input type="file" name="image" id="image" accept="image/*;capture=camera">
                                    @else
                                        <input type="text" readonly="" class="form-control" placeholder="Browse...">
                                        <input type="file" class="form-control-file" name="image" id="image">
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $goal->name) }}" placeholder="Goal name" required autofocus>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="place_id">Place</label>
                                    <select class="form-control selectpicker" name="place_id" id="place_id">
                                        <option value="00" {{ !old('place_id') ? 'selected' : '' }}>Select a place</option>
                                        @foreach($places as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('place_id', $goal->place_id))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label" for="person">Person</label>
                                    <select class="form-control selectpicker" name="person_id" id="person_id">
                                        <option value="00" {{ !old('place_id') ? 'selected' : '' }}>Select a person</option>
                                        @foreach($people as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('people', $goal->person_id))->contains($key)) ? 'selected':'' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label" for="lists">Lists</label>
                                    <select multiple="multiple" class="form-control selectpicker" name="lists[]" id="lists">
                                        @foreach($lists as $key => $value)
                                            <option value="{{ $key }}" {{ (array_key_exists($key, old('lists', $listDataArray))) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="privacy">Privacy</label>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy1" value="0" {{ old("privacy", $goal->privacy) == 0 ? "checked":"" }}>
                                            Myself only
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy2" value="1" {{ old("privacy", $goal->privacy) == 1 ? "checked":"" }}>
                                            My Friends
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy3" value="2" {{ old("privacy", $goal->privacy) == 2 ? "checked":"" }}>
                                            The World
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-raised" data-toggle="tooltip" data-placement="top" title="Add a goal"> Update Goal </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
