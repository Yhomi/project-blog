@extends('layouts.app')
@section('content')
    <h1>Posts</h1>
    @if (count($post)>0)
        @foreach ($post as $posts)
            <div class="card card-body bg-light">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                    <img class="img-fluid" src="{{asset('storage/cover_images/'.$posts->cover_image)}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/lsapp/public/posts/{{$posts->id}}">{{$posts->title}}</a>  </h3>
                        <small>Written on: {{$posts->created_at}} by {{$posts->user->name}} </small>
                    </div>
                </div>

                <br>
            </div>
        @endforeach
        {{-- {{$post->links()}} --}}

    @else
    <p>No Post Found</p>
    @endif
@endsection
