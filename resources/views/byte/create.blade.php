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
                            <input type="hidden" name="usertimezone" id="usertimezone" value="">
                            <script>
                                timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                document.getElementById("usertimezone").value = timezone;
                            </script>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Byte title">
                            </div>
                            <div class="form-group">
                                <label for="story">Story:</label>
                                <textarea name="story" id="story" class="form-control" placeholder="Add a story or notes here" rows="4">{{ old('story') }}</textarea>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="rating">Rating:</label>
                                    <select class="form-control" id="rating" name="rating">
                                        <option value="0" {{ old('rating') == 0 ? 'selected' : '' }}>Unrated</option>
                                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>Hated it</option>
                                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>Didn&lsquo;t like it</option>
                                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>Liked it</option>
                                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>Really liked it</option>
                                        <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>Loved it</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="privacy">Privacy:</label>
                                    <select class="form-control" id="privacy" name="privacy" value="{{ old('privacy') }}">
                                        <option value="0" {{ old("privacy") == 0 ? "selected":"" }}>Myself only</option>
                                        <option value="1" {{ old("privacy") == 1 ? "selected":"" }}>My Friends</option>
                                        <option value="2" {{ old("privacy") == 2 ? "selected":"" }}>The World</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="place_id">Place:</label>
                                    <select class="form-control" name="place_id" id="place_id">
                                        <option value="00" {{ !old('place_id') ? 'selected' : '' }}>Select a place</option>
                                        @foreach($places as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('place_id'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="timezone_id">Time Zone:</label>
                                    <select class="form-control" name="timezone_id" id="timezone_id" >
                                        <option value="00" {{ !old('timezone_id') ? 'selected':'' }}>Select a time zone</option>
                                        @foreach($timezones as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('timezone_id'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <label for="year">Year:</label>
                                    <input type="text" class="form-control" name="year" id="year" value="{{ old('year') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="month">Month:</label>
                                    <input type="text" class="form-control" name="month" id="month" value="{{ old('month') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="day">Day:</label>
                                    <input type="text" class="form-control" name="day" id="day" value="{{ old('day') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="hour">Hour:</label>
                                    <input type="text" class="form-control" name="hour" id="hour" value="{{ old('hour') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="minute">Minute:</label>
                                    <input type="text" class="form-control" name="minute" id="minute" value="{{ old('minute') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="second">Seconds:</label>
                                    <input type="text" class="form-control" name="second" id="second" value="{{ old('second') }}">
                                </div>
                            </div>
                            {{ old("lines->id") }}
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="people">People:</label>
                                    <select class="form-control" multiple="multiple" name="people[]" id="people" class="form-control" >
                                        @foreach($people as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('people'))->contains($key)) ? 'selected':'' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="lines">Lifeline:</label>
                                    <select class="form-control" multiple="multiple" name="lines[]" id="lines" class="form-control" >
                                        @foreach($mylines as $line)
                                            <option value="{{ $line->id }}" {{ (collect(old('lines'))->contains($line->id)) ? 'selected':'' }}>{{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='form-group'>
                                <button type="submit" class="btn btn-primary">Add Byte</button>
                                <a class="btn btn-default" href="{{ URL::previous() }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
