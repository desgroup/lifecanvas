@extends('layouts.app2')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Change Password</h3></div>

                <div class="panel-body">
                    @if(count($errors))
                        <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                    @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                        {{ csrf_field() }}

                        <div class="row form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                            <label for="new-password" class="col-md-4 control-label">Current Password</label>

                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control"
                                       name="current-password" required>

                                @if ($errors->has('current-password'))
                                <p class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                            <label for="new-password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control" name="new-password"
                                       required>

                                @if ($errors->has('new-password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group{{ $errors->has('new-password_confirmation') ? ' has-error' : '' }}">
                            <label for="new-password_confirmation" class="col-md-4 control-label">Confirm New
                                Password</label>

                            <div class="col-md-6">
                                <input id="new-password_confirmation" type="password" class="form-control"
                                       name="new-password_confirmation" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-raised btn-primary">
                                    Change Password
                                </button>
                                <a class="btn btn-default" href="{{ URL::previous() }}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
@endsection
