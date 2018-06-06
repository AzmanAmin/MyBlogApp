@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

            <h1>Media</h1>
            <div class="col-sm-6">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($photos)
                        @foreach($photos as $photo)
                            <tr>
                                <td>{{$photo->id}}</td>
                                <td><img height="50" width="50" src="{{$photo->file ? $photo->file : '/images/user1.png'}}" alt=""></td>
                                <td>{{$photo->created_at->diffForHumans()}}</td>
                                <td>{{$photo->updated_at->diffForHumans()}}</td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE', 'action'=>['AdminMediasController@destroy', $photo->id]]) !!}

                                    <div class="form-group">
                                        {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                                    </div>

                                    {!! Form::close() !!}

                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection