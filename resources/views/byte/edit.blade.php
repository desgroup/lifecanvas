@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Update a Byte</h3></div>

                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/bytes/{{ $byte->id }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" name="usertimezone" id="usertimezone" value="">
                            <script>
                                timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                document.getElementById("usertimezone").value = timezone;
                            </script>
                            <div class="form-group">
                                <div class="col-md-12">
                                <label class="control-label" for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $byte->title) }}" placeholder="Byte title" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                <label class="control-label" for="story">Story</label>
                                <textarea name="story" id="story" class="form-control" placeholder="Add a story or notes here" rows="4">{{ old('story', $byte->story) }}</textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="rating">Rating</label>
                                    <select class="form-control selectpicker" id="rating" name="rating">
                                        <option value="0" {{ old('rating', $byte->rating) == 0 ? 'selected' : '' }}>Unrated</option>
                                        <option value="1" {{ old('rating', $byte->rating) == 1 ? 'selected' : '' }}>Hated it</option>
                                        <option value="2" {{ old('rating', $byte->rating) == 2 ? 'selected' : '' }}>Didn&lsquo;t like it</option>
                                        <option value="3" {{ old('rating', $byte->rating) == 3 ? 'selected' : '' }}>Liked it</option>
                                        <option value="4" {{ old('rating', $byte->rating) == 4 ? 'selected' : '' }}>Really liked it</option>
                                        <option value="5" {{ old('rating', $byte->rating) == 5 ? 'selected' : '' }}>Loved it</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="repeat">Do it again</label>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat1" value="0" {{ old("repeat", $byte->repeat) == 0 && old("repeat", $byte->repeat) <> "" ? "checked":"" }}>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat2" value="1" {{ old("repeat", $byte->repeat) == 1 ? "checked":"" }}>
                                            Maybe
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat3" value="2" {{ old("repeat", $byte->repeat) == 2 ? "checked":"" }}>
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="privacy">Privacy</label>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy1" value="0" {{ old("privacy", $byte->privacy) == 0 ? "checked":"" }}>
                                            Myself only
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy2" value="1" {{ old("privacy", $byte->privacy) == 1 ? "checked":"" }}>
                                            My Friends
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy3" value="2" {{ old("privacy", $byte->privacy) == 2 ? "checked":"" }}>
                                            The World
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="place_id">Place</label>
                                    <select class="form-control selectpicker" name="place_id" id="place_id">
                                        <option value="00" {{ !old('place_id', $byte->place_id) ? 'selected' : '' }}>Select a place</option>
                                        @foreach($places as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('place_id', $byte->place_id))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="timezone_id">Time Zone</label>
                                    <select class="form-control selectpicker" name="timezone_id" id="timezone_id" >
                                        <option value="00" {{ !old('timezone_id', $byte->timezone_id) ? 'selected':'' }}>Select a time zone</option>
                                        @foreach($timezones as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('timezone_id', $byte->timezone_id))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <label class="control-label" for="year">Year</label>
                                    <input type="text" class="form-control" name="year" id="year" value="{{ old('year', $formDate["year"])}}">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="month">Month</label>
                                    <input type="text" class="form-control" name="month" id="month" value="{{ old('month', $formDate["month"])}}">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="day">Day</label>
                                    <input type="text" class="form-control" name="day" id="day" value="{{ old('day', $formDate["day"])}}">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="hour">Hour</label>
                                    <input type="text" class="form-control" name="hour" id="hour" value="{{ old('hour', $formDate["hour"])}}">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="minute">Minute</label>
                                    <input type="text" class="form-control" name="minute" id="minute" value="{{ old('minute', $formDate["minute"])}}">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="second">Seconds</label>
                                    <input type="text" class="form-control" name="second" id="second" value="{{ old('second', $formDate["second"])}}">
                                </div>
                            </div>
                            {{ old("lines->id") }}
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="people">People</label>
                                    <select multiple="multiple" class="form-control selectpicker" name="people[]" id="people">
                                        @foreach($people as $key => $value)
                                            <option value="{{ $key }}" {{ (array_key_exists($key, old('people', $peopleDataArray))) ? 'selected':'' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="lines">Lifeline</label>
                                    <select multiple="multiple" class="form-control selectpicker" name="lines[]" id="lines">
                                        @foreach($mylines as $line)
                                            <option value="{{ $line->id }}" {{ (array_key_exists($line->id, old('lines', $linesDataArray))) ? 'selected':'' }}>{{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <!-- Image File -->
                                <div class="col-md-4">
                                    <label class="control-label" for="image">Image</label>

                                    @if($agent->isMobile() || $agent->isTablet())
                                        <input type="file" name="image" id="image" accept="image/*;capture=camera">
                                    @else
                                        <input type="text" readonly="" class="form-control" placeholder="Browse...">
                                        <input type="file" class="form-control-file" name="image" id="image">
                                    @endif
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-4">
                                    <label class="control-label" for="use_image_time">Use Image Data</label><br>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="use_image_time" id="use_image_time" {{ old('use_image_time') == "on" ? "checked" : ""}}> Use Data </label>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <button type="submit" class="btn btn-raised btn-primary">Update Byte</button>
                                <a class="btn btn-default" href="{{ URL::previous() }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
