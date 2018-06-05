@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-10">

                <h3>{{$post->title}}</h3>
                <p>{{$post->body}}</p>

            </div>

        </div>

    </div>

@endsection

