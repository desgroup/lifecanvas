@extends('layouts.app2')

@section('headcontent')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('css_page')
    <link rel="stylesheet" type="text/css" href="/css/slim.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12 col-md-6 order-md-1">
                        <div class="card animated fadeInUp animation-delay-7">
                            <div class="ms-hero-bg-primary">
                                @if(!is_null($user->first_name) || !is_null($user->last_name))
                                    <h3 class="color-white index-1 text-center no-m pt-4">{{ $user->first_name . " " . $user->last_name }}</h3>
                                    <div class="color-medium index-1 text-center np-m">{{ "@" . $user->username }}</div>
                                @else
                                    <h3 class="color-white index-1 text-center no-m pt-4">{{ "@" . $user->username }}</h3>
                                @endif
                                    <div class="slim img-avatar-circle"
                                         data-ratio="1:1"
                                         data-service="/photo/async"
                                         data-fetcher="/photo/fetch"
                                         data-force-type="jpg"
                                         data-size="1000,1000"
                                         data-push="true"
                                         style="z-index: 1;">
                                        <input type="file" name="slim[]"/>
                                        @if(is_null($user->avatar))
                                            <img src="/assets/img/silhouette.png" alt="avatar" class="img-avatar-circle">
                                        @else
                                            <img src="/usr/{{ $user->id }}/avatar/{{ $user->avatar }}avatar.jpg" alt="avatar" class="img-avatar-circle">
                                        @endif
                                        <img src="/assets/img/silhouette.png" alt="avatar" class="img-avatar-circle">
                                    </div>

                            </div>
                            <div class="card-block pt-4 text-center">
                                <h3 class="color-primary">Stats</h3>
                                <div class="text-left">
                                    Lifer Since: {{ $user->created_at->diffForHumans() }} ({{$user->created_at}})<br>
                                    @if(isset($aliveTime))
                                        Alive for: {{ $aliveTime }}
                                    @endif
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-primary animated fadeInUp animation-delay-7">
                    <div class="card-body">
                        <h2 class="color-primary text-center">Update Your Profile</h2>
                        @if(count($errors))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="zmdi zmdi-close"></i>
                                </button>
                                <strong>
                                    <i class="zmdi zmdi-close-circle"></i> Error!</strong><br>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form  method="POST" action="/{{ $user->username }}" class="form-horizontal">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PATCH">
                            <fieldset>
                                <div class="row form-group">
                                    <label for="birthdate" class="col-md-2 control-label">Birthdate</label>
                                    <div class="col-md-9">
                                        <input name="birthdate" id="datePicker" type="text" class="form-control" value="{{ old('birthdate', $birthdate) }}" placeholder="mm/dd/yy"> </div>
                                </div>
                                <div class="row form-group">
                                    <label for="first_name" class="col-md-2 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input name="first_name" type="text" class="form-control" id="inputName" value="{{ old('first_name', $user->first_name) }}" placeholder="First Name"> </div>
                                </div>
                                <div class="row form-group">
                                    <label for="last_name" class="col-md-2 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input name="last_name" type="text" class="form-control" id="inputLast" value="{{ old('last_name', $user->last_name) }}" placeholder="Last Name"> </div>
                                </div>
                                <div class="row form-group">
                                    <label for="email" class="col-md-2 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input name="email" type="email" class="form-control" id="inputEmail" value="{{ old('email', $user->email) }}" placeholder="Email"> </div>
                                </div>
                                <div class="row form-group">
                                    <label for="confirm_email" class="col-md-2 control-label">Confirm Email</label>
                                    <div class="col-md-9">
                                        <input name="confirm_email" type="email" class="form-control" id="inputConfirmEmail" value="{{ old('email_confirm', $user->email) }}" placeholder="Retype Email"> </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-lg-2 control-label" for="home_country_code">Country</label>
                                    <div class="col-md-9">
                                    <select class="form-control selectpicker" name="home_country_code" id="home_country_code">
                                        <option value="00" {{ !old('home_country_code') ? 'selected' : '' }}>Select a country</option>
                                        @foreach($countries as $key => $value)
                                            <option value="{{ $key }}" {{ (collect(old('home_country_code', $user->home_country_code))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="privacy" class="col-lg-2 control-label">Default Privacy</label>
                                    <div class="col-md-9">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="privacy" id="privacy1" value="0" {{ old("privacy", $user->privacy) == 0 ? "checked":"" }} checked=""> Myself</label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="privacy" id="privacy2" value="1" {{ old("privacy", $user->privacy) == 1 ? "checked":"" }}> Friends and Family</label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="privacy" id="privacy2" value="2" {{ old("privacy", $user->privacy) == 2 ? "checked":"" }}> World</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <button type="submit" class="btn btn-raised btn-primary btn-block">Update</button>
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
    <script src="/js/slim.kickstart.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection
