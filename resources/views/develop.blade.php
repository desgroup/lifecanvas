@extends('layouts.app2')

@section('content')

    <div class="container">
        <div class="row">
            <h1>Lifebytes</h1>
            <div class="row">
            <div class="col-lg-3">

                <div class="card card-primary animated zoomInUp animation-delay-7">
                    <div class="card-header">
                        <h3 class="card-title">Display Bytes as . . .</h3>
                    </div>
                    <div class="list-group">
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                            <i class="zmdi zmdi-view-list"></i> Timeline
                        </a>
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                            <i class="zmdi zmdi-camera"></i> Images
                        </a>
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                            <i class="zmdi zmdi-pin"></i>Map
                        </a>
                    </div>
                </div>
            </div>

           <div class="col-lg-9">
                <ul class="ms-timeline">
                    <li class="ms-timeline-item wow materialUp">
                        <div class="ms-timeline-date">
                            <time class="timeline-time" datetime="">2016
                                <span>October</span>
                            </time>
                            <i class="ms-timeline-point"></i>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Simple text event in Timeline</h3>
                            </div>
                            <div class="card-body"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus officiis autem magni et, nisi eveniet nulla magnam tenetur voluptatem dolore, assumenda delectus error porro animi architecto dolorum quod veniam nesciunt. </div>
                        </div>
                    </li>
                </ul>
            </div>
            </div>
        </div>
    </div>
    <!-- container -->

@endsection

@section('onPageCSS')
@stop
