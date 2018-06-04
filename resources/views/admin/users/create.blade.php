@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h1>Create Page</h1>

                {!! Form::open(['method'=>'POST', 'action'=>'AdminUsersController@store', 'files'=>true]) !!}

                	<div class="form-group">
                		{!! Form::label('name', 'Name: ') !!}
                		{!! Form::text('name', null, ['class'=>'form-control']) !!}
                	</div>

                    <div class="form-group">
                        {!! Form::label('email', 'Email: ') !!}
                        {!! Form::email('email', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('role_id', 'Role: ') !!}
                        {!! Form::select('role_id', ['' => 'Choose Options'] + $roles, null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('is_active', 'Status: ') !!}
                        {!! Form::select('is_active', array(1 => 'Active', 0 => 'Inactive'), 0, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('photo_id', 'Photo: ') !!}
                        {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Password: ') !!}
                        {!! Form::password('password', ['class'=>'form-control']) !!}
                    </div>

                	<div class="form-group">
                		{!! Form::submit('Create User', ['class'=>'btn btn-primary']) !!}
                	</div>

                {!! Form::close() !!}

                @if($errors->any())
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