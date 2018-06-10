@extends('layouts.masterpost')

@section('content')

    <h4><small>RECENT POSTS</small></h4>
    <hr>
    <h2>{{$post->title}}</h2>
    <h4><span class="label label-danger">{{$post->category->name}}</span> </h4>
    <h4>Posted by {{$post->user->name}}</h4>
    <h5><span class="glyphicon glyphicon-time"></span> On {{$post->created_at->toDayDateTimeString()}}</h5>
    <hr>
    <img class="img-fluid rounded" height="300" width="500" src="{{$post->photo ? $post->photo->file : '/images/contract.png'}}">
    <hr>
    <p>{{$post->body}}</p>
    <hr>
    <br>

    {{--Creating Comment Section--}}
    @if(Auth::check())

        <h4>Leave a Comment:</h4>

        {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store']) !!}

        <input type="hidden" name="post_id" value="{{$post->id}}">

        <div class="form-group">
            {{--{!! Form::label('body', 'Comment: ') !!}--}}
            {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

        <hr>
        <br>

    @endif


    {{--Showing Comments Section--}}
    <p><span class="badge">{{count($comments)}}</span> Comments:</p><br>

    @if(count($comments) > 0)

        @foreach($comments as $comment)

            <div class="row">
                <div class="col-sm-2 text-center">
                    <img src="{{$comment->photo ? $comment->photo : '/images/chat.png'}}" height="65" width="65" alt="Avatar">
                </div>
                <div class="col-sm-10">
                    <h4>{{$comment->author}} <small>{{$comment->created_at->toDayDateTimeString()}}</small></h4>
                    <p>{{$comment->body}}</p>
                    <br>

                    {{--Showing Reply Section--}}
                    <p><span class="badge">{{count($comment->replies)}}</span> Replies</p>

                    <div class="comment-reply-container">
                        @if(count($comment->replies) > 0)
                            <a class="toggle-reply">Show More</a>
                            <div class="comment-reply">
                                <br>
                                @foreach($comment->replies as $reply)
                                    @if($reply->is_active == 1)
                                        <div class="row">
                                            <div class="col-sm-2 text-center">
                                                <img src="{{$reply->photo ? $reply->photo : '/images/chat.png'}}" class="img-circle" height="55" width="55" alt="Avatar">
                                            </div>
                                            <div class="col-xs-10">
                                                <h4>{{$reply->author}} <small>{{$reply->created_at->toDayDateTimeString()}}</small></h4>
                                                <p>{{$reply->body}}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <br>

                    <div class="col-sm-8">
                            {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply', 'files'=>true]) !!}

                            <input type="hidden" name="comment_id" value="{{$comment->id}}">

                            <div class="form-group">
                                {!! Form::label('body', 'Reply: ') !!}
                                {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>1]) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
                            </div>

                            {!! Form::close() !!}
                            <hr>
                    </div>
                </div>
            </div>

        @endforeach

    @endif

@endsection
