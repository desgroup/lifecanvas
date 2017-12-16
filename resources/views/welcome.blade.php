@extends('layouts.app')

@section('headcontent')
    <link href='http://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
@stop

@section('content')
    <!-- content -->
    <div class="container content">
        <div class="centered">
            <h1 class="brand-font">Lifecanvas</h1>
            <p class="subtitle">Capture your past, present and future</p>
            <p class="main-buttons">
                <a href="/login" class="well">Sign In</a>
                <a href="#" class="well">Sign Up</a>
            </p>
        </div> <!-- end centered -->
    </div>
    <!-- end content -->
@stop

@section('onPageCSS')
    <style type="text/css">

        h1 {

            font-size: 100px;
            color: white;
            text-shadow: 0 1px 3px rgba(0,0,0,.4), 0 0 30px rgba(0,0,0,.075);

        }

        .subtitle {
            font-size: 35px;
            padding-top: 0px;
            letter-spacing:1px;
            line-height: 40px;
            color: white;
        }

        .centered {
            margin-top: 15%;
            margin-left: 10%;

        }

        a.well {
            background: #63c918;
            border: none;
            border-bottom: 1px solid #b4e391;
            box-shadow: inset 0 2px 5px #339900;
            padding: 9px 12px;
            font-size: 25px;
            color: #fbfbfb;
            margin-right: 30px;

        }

        .main-buttons {
            margin-top: 70px;
        }

        .container {
            position: absolute;
            top: 0;
            min-height: 100%;
            height: 100%;
            width: 100%;

            background-color: #b4e391;
            background: #b4e391; /* Old browsers */
            background: -moz-radial-gradient(center, ellipse cover,  #b4e391 0%, #61c419 100%); /* FF3.6+ */
            background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,#b4e391), color-stop(100%,#61c419)); /* Chrome,Safari4+ */
            background: -webkit-radial-gradient(center, ellipse cover,  #b4e391 0%,#61c419 100%); /* Chrome10+,Safari5.1+ */
            background: -o-radial-gradient(center, ellipse cover,  #b4e391 0%,#61c419 100%); /* Opera 12+ */
            background: -ms-radial-gradient(center, ellipse cover,  #b4e391 0%,#61c419 100%); /* IE10+ */
            background: radial-gradient(ellipse at center,  #b4e391 0%,#61c419 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#61c419', endColorstr='#b4e391',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

        }

        .bottom-nav {
            margin: 0 15%;
        }

        .navbar-inner {
            background: #63c918;
            color: #fff;
        }
    </style>
@stop