@extends('layouts.app')

@section('css_page')
    <link rel="stylesheet" type="text/css" href="/css/slim.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Live Photo Editing</h3>
                <div class="slim"
                     data-service="async.php"
                     data-fetcher="/photo/fetch"
                     data-max-file-size="10">
                    <img src="/usr/1/org/1-55bfa9b56c0e28-14065503.jpg" alt=""/>
                    <input type="file" name="slim[]"/>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_scripts')
    <script src="/js/slim.kickstart.min.js"></script>
@endsection
