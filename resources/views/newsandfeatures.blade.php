
@extends('layout.layout')

@section('title', 'News and features | The Scitech')

@section('content')

<div class="row mt-2">
    <!---- Right Side ------->
    <div class="col-md-8">  
        <div class="title-box mt-2"><span>News & Features</span></div>
        <div class="row">
            @foreach($data as $post)
            <div class="list-news">
                <div class="col-md-3 float-left pr-0 img-hover">
                    <img src="{{url('public/storage/images/posts/'.$post->image_name) }}" class="image-fit" >  
                    @foreach($post->tags as $tag)
                    <span class="news-tag" style="background:#{{$tag->background}};color:#{{$tag->color}};margin-left:5px; position:relative;top:-30px;">{{$tag->name}}</span>
                    @endforeach
                </div>
                <div class="col-md-9 float-right pr-0">
                    <h4><a href="{{url('post/'.$post->slug)}}">{{$post->title}}</a></h4>
                    <div class="list-date"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> {{date('F j, Y', strtotime($post->datefor))}}</div>
                    <div class="list-author"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{$post->author}}</div>
                    <div class="clearfix"></div>
                    <p>{!! $post->short_message !!}</p>
                </div>
            </div>
            <div class="bottom-line pt-1"></div>
            @endforeach
            {{$data->links()}}
        </div>
    </div>
    <!---- Left Side ------->
    <div class="col-md-4">
        @include('leftsidepanel') 
    </div>
    <div class="clearfix"></div>
</div>

@endsection
