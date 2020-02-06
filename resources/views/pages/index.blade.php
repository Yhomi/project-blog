@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1>{{$title}}</h1>
    <p>This is Laravel Application Built From Scratch</p>
    <p><a  href="/lsapp/public/login" class="btn btn-primary btn-lg">Login</a> <a href="/lsapp/public/register" class="btn btn-success btn-lg">Register</a></p>
  </div>

@endsection

