@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-warning"></i> {{ $heading }}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <p>{{ $message }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection