@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                @include('goal.item')
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Select an existing Byte</h3></div>
                    <div class="panel-body">
                        <form method="POST" action="/goals/completed/{{ $goal->id }}">
                            <fieldset>
                                {{ csrf_field() }}
                                <div class='row form-group'>
                                    <div class="col-md-12">
                                        <label class="control-label" for="byte_id">Select a Byte to complete a goal</label>
                                        <select class="form-control selectpicker" name="byte_id" id="byte_id">
                                            <option value="00" {{ !old('byte_id') ? 'selected' : '' }}>Select a byte</option>
                                            @foreach($bytes as $key => $value)
                                                <option value="{{ $key }}" {{ (collect(old('byte_id'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class='row form-group'>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-raised btn-primary">Join Byte</button>
                                        <a class="btn btn-default" href="{{ URL::previous() }}">Cancel</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Create a new Byte</h3></div>
                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/bytes" enctype="multipart/form-data">
                            <fieldset>
                            {{ csrf_field() }}
                            <input type="hidden" name="goal_id" id="goal_id" value="{{ $goal->id }}">
                            <input type="hidden" name="usertimezone" id="usertimezone" value="">
                            <input type="hidden" name="year" id="year" value="">
                            <input type="hidden" name="month" id="month" value="">
                            <input type="hidden" name="day" id="day" value="">
                            <input type="hidden" name="hour" id="hour" value="">
                            <input type="hidden" name="minute" id="minute" value="">
                            <script>
                                timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                document.getElementById("usertimezone").value = timezone;
                                myDate = new Date();
                                document.getElementById('year').value = myDate.getFullYear();
                                document.getElementById('month').value = myDate.getMonth() + 1;
                                document.getElementById('day').value = myDate.getDate();
                                document.getElementById('hour').value = myDate.getHours();
                                document.getElementById('minute').value = myDate.getMinutes();
                                document.getElementById('second').value = myDate.getSeconds();
                            </script>

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
                                <label class="control-label" for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Byte title" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                <label class="control-label" for="story">Story</label>
                                <textarea name="story" id="story" class="form-control" placeholder="Add a story or notes here" rows="4">{{ old('story') }}</textarea>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="rating">Rating</label>
                                    <select class="form-control selectpicker" id="rating" name="rating" data-dropup-auto="false">
                                        <option value="0" {{ old('rating') == 0 ? 'selected' : '' }}>Unrated</option>
                                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>Hated it</option>
                                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>Didn&lsquo;t like it</option>
                                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>Liked it</option>
                                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>Really liked it</option>
                                        <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>Loved it</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label" for="repeat">Do it again</label>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat1" value="0" {{ old("repeat") == 0 && old("repeat") <> "" ? "checked":"" }}>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat2" value="1" {{ old("repeat") == 1 ? "checked":"" }}>
                                            Maybe
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat3" value="2" {{ old("repeat") == 2 ? "checked":"" }}>
                                            No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
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

                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="place_id">Place:</label>
                                    <select class="form-control selectpicker" name="place_id" id="place_id">
                                        <option value="00" {{ !old('place_id') ? 'selected' : '' }}>Select a place</option>
                                        @foreach($places as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('place_id'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="people">People:</label>
                                    <select multiple="multiple" class="form-control selectpicker" name="people[]" id="people">
                                        @foreach($people as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('people'))->contains($key)) ? 'selected':'' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="lines">Lifeline:</label>
                                    <select multiple="multiple" class="form-control selectpicker" name="lines[]" id="lines">
                                        @foreach($mylines as $line)
                                            <option value="{{ $line->id }}" {{ (collect(old('lines'))->contains($line->id)) ? 'selected':'' }}>{{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row form-group'>
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-raised btn-primary">Join Byte</button>
                                <a class="btn btn-default" href="{{ URL::previous() }}">Cancel</a>
                                </div>
                            </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_scripts')
@endsection

@section('css_page')
    <style>
        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .image-container img {
            object-fit: cover;
        }

        .mt-12{
            margin-top:120px!important;
            margin-top:12rem!important
        }

    </style>
@endsection