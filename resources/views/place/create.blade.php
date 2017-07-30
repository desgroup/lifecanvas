@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Add a Place</h3></div>

                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="/places">
                            {{ csrf_field() }}
                            <input type="hidden" name="usertimezone" id="usertimezone" value="">
                            <script>
                                timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                document.getElementById("usertimezone").value = timezone;
                            </script>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Place name">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Street address for place">
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="city">City:</label>
                                    <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" placeholder="City">
                                </div>
                                <div class="col-md-4">
                                    <label for="province">Province:</label>
                                    <input type="text" class="form-control" name="province" id="province" value="{{ old('province') }}" placeholder="Province">
                                </div>
                                <div class="col-md-4">
                                    <label for="country_code">Country:</label>
                                    <select class="form-control" name="country_code" id="country_code">
                                        <option value="00" {{ !old('country_code') ? 'selected' : '' }}>Select a country</option>
                                        @foreach($countries as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('country_code'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="url_place">Place URL:</label>
                                    <input type="text" class="form-control" name="url_place" id="url_place" value="{{ old('url_place') }}" placeholder="A link to the place's web site">
                                </div>
                                <div class="col-md-6">
                                    <label for="url_wikipedia">Wikipedia URL:</label>
                                    <input type="text" class="form-control" name="url_wikipedia" id="url_wikipedia" value="{{ old('url_wikipedia') }}" placeholder="A link to the place's wikipedia web page">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="lat">Latitude:</label>
                                    <input type="text" class="form-control" name="lat" id="lat" value="{{ old('lat') }}" placeholder="In this form: -71.002178">
                                </div>
                                <div class="col-md-4">
                                    <label for="lng">Longitude:</label>
                                    <input type="text" class="form-control" name="lng" id="lng" value="{{ old('lng') }}" placeholder="In this form: -71.002178">
                                </div>
                                <div class="col-md-4">
                                    <label for="map_zoom">Map Zoom Level:</label>
                                    <input type="text" class="form-control" name="map_zoom" id="map_zoom" value="{{ old('map_zoom') }}" placeholder="Google maps map_zoom level">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="image_id">Image ID:</label>
                                    <input type="text" class="form-control" name="image_id" id="image_id" value="{{ old('image_id') }}" placeholder="Id of image you want related to place">
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
                                <div class="col-md-4">
                                    <label for="extant">Extant:</label>
                                    <select class="form-control" name="extant" id="extant" >
                                        <option value="1" {{ (collect(old('extant'))->contains('Yes')) ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ (collect(old('extant'))->contains('No')) ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group'>
                                <button type="submit" class="btn btn-primary">Add Place</button>
                                <a class="btn btn-default" href="{{ URL::previous() }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection