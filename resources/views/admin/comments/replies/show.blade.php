@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-10">

                <h1>Replies of the Comment</h1>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Comment</th>
                        <th>Author</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Body</th>
                        <th>Comment Link</th>
                        {{--<th>Created</th>--}}
                        {{--<th>Updated</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @if($replies)
                        @foreach($replies as $reply)
                            <tr>
                                <td>{{$reply->id}}</td>
                                <td>{{$reply->comment_id}}</td>
                                <td>{{$reply->author}}</td>
                                <td>{{$reply->email}}</td>
                                <td><img height="50" width="50" src="{{$reply->photo ? $reply->photo : '/images/chat.png'}}"></td>
                                <td>{{$reply->is_active}}</td>
                                <td>{{str_limit($reply->body, 20)}}</td>
                                <td><a href="{{route('home.post', $reply->comment->post->id)}}">View Comment</a></td>
                                {{--<td>{{$comment->created_at->diffForHumans()}}</td>--}}
                                {{--<td>{{$comment->updated_at->diffForHumans()}}</td>--}}
                                <td>
                                    @if($reply->is_active == 1)

                                        {!! Form::open(['method'=>'PATCH', 'action'=>['CommentRepliesController@update', $reply->id]]) !!}

                                        <input type="hidden" name="is_active" value="0">

                                        <div class="form-group">
                                            {!! Form::submit('Un-Approve', ['class'=>'btn btn-primary']) !!}
                                        </div>

                                        {!! Form::close() !!}

                                    @else

                                        {!! Form::open(['method'=>'PATCH', 'action'=>['CommentRepliesController@update', $reply->id]]) !!}

                                        <input type="hidden" name="is_active" value="1">

                                        <div class="form-group">
                                            {!! Form::submit('Approve', ['class'=>'btn btn-success']) !!}
                                        </div>

                                        {!! Form::close() !!}

                                    @endif
                                </td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE', 'action'=>['CommentRepliesController@destroy', $reply->id]]) !!}

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