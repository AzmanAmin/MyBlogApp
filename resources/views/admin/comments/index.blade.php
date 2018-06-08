@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-10">

                <h1>Comments</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Post</th>
                            <th>Author</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Body</th>
                            {{--<th>Created</th>--}}
                            {{--<th>Updated</th>--}}
                        </tr>
                    </thead>
                    <tbody>
                        @if($comments)
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{$comment->id}}</td>
                                    <td>{{$comment->post_id}}</td>
                                    <td>{{$comment->author}}</td>
                                    <td>{{$comment->email}}</td>
                                    <td><img height="50" width="50" src="{{$comment->photo ? $comment->photo : '/images/chat.png'}}"></td>
                                    <td>{{$comment->is_active}}</td>
                                    <td><a href="{{route('home.post', $comment->post->id)}}">View Post</a></td>
                                    {{--<td>{{$comment->created_at->diffForHumans()}}</td>--}}
                                    {{--<td>{{$comment->updated_at->diffForHumans()}}</td>--}}
                                    <td>
                                        @if($comment->is_active == 1)

                                            {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}

                                                <input type="hidden" name="is_active" value="0">

                                            	<div class="form-group">
                                            		{!! Form::submit('Un-Approve', ['class'=>'btn btn-primary']) !!}
                                            	</div>

                                            {!! Form::close() !!}

                                        @else

                                            {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}

                                                <input type="hidden" name="is_active" value="1">

                                                <div class="form-group">
                                                    {!! Form::submit('Approve', ['class'=>'btn btn-success']) !!}
                                                </div>

                                            {!! Form::close() !!}

                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['PostCommentsController@destroy', $comment->id]]) !!}

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