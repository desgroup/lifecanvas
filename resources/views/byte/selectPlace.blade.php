@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Select a Place for {{ $byte->title }}</h3></div>
                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/bytes/addPlace/{{ $byte->id }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="select">
                            <div class="col-md-8">
                                <label class="place_selected_code" for="place_selected_code">Related Place</label>
                                <select class="form-control selectpicker" name="place_selected_code" id="place_selected_code">
                                    <option value="00" {{ !old('place_selected_code') ? 'selected' : '' }}>No place selected</option>
                                    @foreach($places as $place)
                                        <option value="{{ $place->id }}" {{ (collect(old('place_selected_code'))->contains($place->id)) ? 'selected' : '' }}>{{ $place->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='form-group'>
                                <button type="submit" class="btn btn-raised btn-primary">Select a Place</button>
                                <a class="btn btn-default" href="/bytes/{{ $byte->id }}">Skip</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 mt-1 mb-1" style="text-align: center">
                <span class="ms-icon ms-icon-circle">
                    OR
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Add a Place to {{ $byte->title }}</h3></div>
                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/bytes/addPlace/{{ $byte->id }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="add">
                            <input type="hidden" name="usertimezone" id="usertimezone" value="">
                            <script>
                                timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                document.getElementById("usertimezone").value = timezone;
                            </script>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Place name" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Street address for place">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" placeholder="City">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="province">Province</label>
                                    <input type="text" class="form-control" name="province" id="province" value="{{ old('province') }}" placeholder="Province">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="country_code">Country</label>
                                    <select class="form-control selectpicker" name="country_code" id="country_code">
                                        <option value="00" {{ !old('country_code') ? 'selected' : '' }}>Select a country</option>
                                        @if(!is_null($home_country))
                                            <option value="{{ key($home_country) }}">{{ reset($home_country) }}</option>
                                        @endif
                                        @foreach($countries as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('country_code'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="url_place">Place URL</label>
                                    <input type="text" class="form-control" name="url_place" id="url_place" value="{{ old('url_place') }}" placeholder="A link to the place's web site">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="url_wikipedia">Wikipedia URL</label>
                                    <input type="text" class="form-control" name="url_wikipedia" id="url_wikipedia" value="{{ old('url_wikipedia') }}" placeholder="A link to the place's wikipedia web page">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="lat">Latitude</label>
                                    <input type="text" class="form-control" name="lat" id="lat" value="{{ old('lat', $byte->lat) }}" placeholder="In this form: 43.002178">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="lng">Longitude</label>
                                    <input type="text" class="form-control" name="lng" id="lng" value="{{ old('lng', $byte->lng) }}" placeholder="In this form: -71.002178">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="map_zoom">Map Zoom Level</label>
                                    <input type="text" class="form-control" name="map_zoom" id="map_zoom" value="{{ old('map_zoom') }}" placeholder="Google maps zoom level">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="image_id">Image ID</label>
                                    <input type="text" class="form-control" name="image_id" id="image_id" value="{{ old('image_id') }}" placeholder="Id of image you want related to place">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="timezone_id">Time Zone</label>
                                    <select class="form-control selectpicker" name="timezone_id" id="timezone_id" >
                                        <option value="00" {{ !old('timezone_id') ? 'selected':'' }}>Select a time zone</option>
                                        @foreach($timezones as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('timezone_id'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="extant">Still Exists</label>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="extant" id="extant1" value="0" {{ old("extant") == 1 || old("extant") == "" ? "checked":"" }}>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input class="form-check-input" type="radio" name="extant" id="extant2" value="1" {{ old("extant") == 0 && old("extant") <> "" ? "checked":"" }}>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
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

                            <div class='form-group'>
                                <button type="submit" class="btn btn-raised btn-primary">Add Place</button>
                                <a class="btn btn-default" href="/bytes/{{ $byte->id }}">Skip</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
