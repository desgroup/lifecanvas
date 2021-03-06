@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="">
                    <h2 class="left" style="text-transform: uppercase;">GOAL: {{ $goal->name }}</h2>
                    <div class="edit">
                        <a href="/goals/{{ $goal->id }}/edit" class="ms-icon ms-icon-circle ms-icon-sm" data-toggle="tooltip" data-placement="top" title="Edit this goal"><i class="fa fa-pencil"></i></a>
                    </div>
                </div>
                @include('goal.item')

                @foreach($bytes as $byte)

                    <div class="row">
                        <div class="col-md-12">

                            <a href="/bytes/{{ $byte->id }}">
                                <div class="card {{ $byte->user_id == Auth::user()->id ? 'card-success' : 'card-info' }}">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $byte->title }}</h3>
                                        <form method="POST" action="/goals/removeByte/{{ $goal->id }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="byte_id" id="byte_id" value="{{ $byte->id }}">
                                            <button class="x" data-toggle="tooltip" data-placement="top" title="Remove this byte">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="card-block">
                                        <div class="row" style="color: #212529">
                                            @if(is_null($byte->asset_id))
                                                <div class="col-sm-12">
                                                    <p style="color: #212529">{{ $byte->story }}</p>
                                                    @if ($byte->place_id > 0)
                                                        {{ $byte->place->name }}<br>
                                                    @endif
                                                    <div style="color: #212529">@include('byte.partials.rating')  @include('byte.partials.repeat')</div>
                                                </div>
                                            @else
                                                <div class="col-sm-3">
                                                    <img src="{{ $byte->thumbnail() }}" alt="" class="img-fluid"></div>
                                                <div class="col-sm-9">
                                                    <p style="color: #212529">{{ $byte->story }}</p>
                                                    @if ($byte->place_id > 0)
                                                        {{ $byte->place->name }}<br>
                                                    @endif
                                                    <div>@include('byte.partials.rating')  @include('byte.partials.repeat')</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>

                @endforeach
                <h4><a href="/goals/complete/{{ $goal->id }}">Add a byte to complete this goal</a></h4>
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

        .page-title {
            display:-webkit-flex;
            display:flex;
            list-style-type:none;
            padding:0;
            justify-content:flex-end;
        }

        .left {
            margin-right:auto;
        }

        .x {
            position: absolute;
            background: #87cb12;
            color: white;
            border:none;
            top: 10px;
            right: 0px;
        }

        .edit {
            position: absolute;
            top: 20px;
            right: 10px;
        }

    </style>
@endsection