
@extends('layout.layout')

@section('title', 'Home Page')

@section('content')


    <!---- Right Side ------->
    <div class="col-md-8">
        <div class="row mt-2">
            {!!$data!!}
        </div>
    </div>
    <!---- Left Side ------->
    <div class="col-md-4">
        @include('leftsidepanel') 
    </div>
    <div class="clearfix"></div>


@endsection
