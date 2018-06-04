@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <h1>User Edit Page</h1>

            <div class="col-sm-3">
                <img src="{{$user->photo ? $user->photo->file : '/images/user4.png'}}" alt="" class="img-responsive img-rounded">
            </div>

            <div class="col-sm-6">

                {!! Form::model($user, ['method'=>'PATCH', 'action'=>['AdminUsersController@update', $user->id], 'files'=>true]) !!}

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
                    {!! Form::select('is_active', array(1 => 'Active', 0 => 'Inactive'), null, ['class'=>'form-control']) !!}
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
                    {!! Form::submit('Update User', ['class'=>'btn btn-primary col-sm-6']) !!}
                </div>

                {!! Form::close() !!}


                {{--Delete User--}}
                {!! Form::open(['method'=>'DELETE', 'action'=>['AdminUsersController@destroy', $user->id]]) !!}

                	<div class="form-group">
                		{!! Form::submit('Delete User', ['class'=>'btn btn-danger col-sm-6']) !!}
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