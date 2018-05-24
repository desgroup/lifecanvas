@extends('layouts.app2')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 ms-paper-content-container">
                <div class="ms-paper-content">
                    <h1>Lifelists</h1>
                    <h3>Number of lifelists: {{ $lists->count() }}</h3>
                    <section class="ms-component-section">
                        <div class="row">
                            @forelse($lists as $list)
                            <div class="col-md-3">
                                <div class="card">
                                    <a href="/lists/{{ $list->id }}">
                                    <div class="image-container" style="display: flex; align-items: center; justify-content: center; background-color: #F2F2F2">
                                        @if(is_null($list->listImage()))
                                            <i class="icon-byte-icon2" style="font-size: 100px; color: #87cb12; "></i>
                                        @else
                                            <img src="{{ $list->listImage()->medium() }}" alt="" class="img-fluid">
                                        @endif
                                    </div>
                                    </a>
                                    <div class="card-body text-center">
                                        <h4 class="color-primary"><a href="/lists/{{ $list->id }}">{{ $list->name }}</a></h4>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="col-md-12">
                                    <p>You have no lifelists. <a href="/lists/create">Add a lifelist.</a></p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->

@endsection

@section('onPageCSS')

    <style type="text/css">
        .image-container {
            height: 12em;
            width: 100%;
            overflow: hidden;
            resize: both;
        }
        .image-container img {
            object-fit: contain;
            width: 100%;
        }
    </style>
@stop
