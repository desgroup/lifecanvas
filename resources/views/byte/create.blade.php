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
                        <form method="POST" action="/bytes" enctype="multipart/form-data">
                            {{ csrf_field() }}
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
                                <div class="col-md-4">
                                    <label for="image">Image:</label>
                                    @if($agent->isMobile() || $agent->isTablet())
                                        <input type="file" name="image" id="image" accept="image/*;capture=camera">
                                    @else
                                        <input type="file" class="form-control-file" name="image" id="image">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Byte title" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="story">Story:</label>
                                <textarea name="story" id="story" class="form-control" placeholder="Add a story or notes here" rows="4">{{ old('story') }}</textarea>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <label for="repeat">Do it again:</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat1" value="0" {{ old("repeat") == 0 ? "checked":"" }}>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat2" value="1" {{ old("repeat") == 1 ? "checked":"" }}>
                                            Maybe
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="repeat" id="repeat3" value="2" {{ old("repeat") == 2 ? "checked":"" }}>
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="privacy">Privacy:</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy1" value="0" {{ old("privacy") == 0 ? "checked":"" }}>
                                            Myself only
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy2" value="1" {{ old("privacy") == 1 ? "checked":"" }}>
                                            My Friends
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="privacy" id="privacy3" value="2" {{ old("privacy") == 2 ? "checked":"" }}>
                                            The World
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="place_id">Place:</label>
                                    <select class="form-control" name="place_id" id="place_id">
                                        <option value="00" {{ !old('place_id') ? 'selected' : '' }}>Select a place</option>
                                        @foreach($places as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('place_id'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                                {{ old("lines->id") }}
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="people">People:</label>
                                    <select multiple="multiple" class="form-control" name="people[]" id="people">
                                        @foreach($people as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('people'))->contains($key)) ? 'selected':'' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="lines">Lifeline:</label>
                                    <select multiple="multiple" class="form-control" name="lines[]" id="lines">
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

@section('js_scripts')
@endsection
