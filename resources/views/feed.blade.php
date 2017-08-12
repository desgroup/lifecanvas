@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Feed</h3></div>
                <div class="panel-body">
                    @foreach($bytes as $byte)
                        @include('byte.byte')
                    @endforeach
                    {{ $bytes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
