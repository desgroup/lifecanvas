@extends('layouts.app2')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 ms-paper-content-container">
                <div class="ms-paper-content">
                    <h1>My People</h1>
                    <h3>Number of people: {{ $people->count() }}</h3>
                    <section class="ms-component-section">
                        <div class="row">
                            @forelse($people as $person)
                                <div class="col-md-3">
                                    <div class="card">
                                        <a href="/people/{{ $person->id }}">
                                            <div class="image-container" style="display: flex; align-items: center; justify-content: center; background-color: #F2F2F2">
                                                @if(is_null($person->byteImage()))
                                                    <i class="icon-byte-icon2" style="font-size: 100px; color: #87cb12; "></i>
                                                @else
                                                    <img src="{{ $person->byteImage()->medium() }}" alt="" class="img-fluid">
                                                @endif
                                            </div>
                                        </a>
                                        <div class="card-body text-center">
                                            <h4 class="color-primary"><a href="/people/{{ $person->id }}">{{ $person->name }}</a></h4>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>You have no people. <a href="/people/create">Add a person.</a></p>
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
