@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h1>Create Posts</h1>

                {!! Form::open(['method'=>'POST', 'action'=>'AdminPostsController@store', 'files'=>true]) !!}

                <div class="form-group">
                    {!! Form::label('title', 'Title: ') !!}
                    {!! Form::text('title', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('category_id', 'Category: ') !!}
                    {!! Form::select('category_id', [''=>'Choose Options'] + $categories, null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('photo_id', 'Photo: ') !!}
                    {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('body', 'Description: ') !!}
                    {!! Form::textarea('body', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Create Post', ['class'=>'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}

                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li> {{$error}} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection