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

    {{--Like Button--}}
    @if($likeState == 0)
        {{--INSERT--}}
        {!! Form::open(['method'=>'POST', 'action'=>'LikesController@store', 'files'=>true]) !!}

            <input type="hidden" name="post_id" value="{{$post->id}}">

        	<div class="form-group">
        		{!! Form::submit('Like', ['class'=>'btn btn-success']) !!}
        	</div>

        {!! Form::close() !!}

    @elseif($likeState == 1)
        {{--UPDATE--}}
        {!! Form::open(['method'=>'PATCH', 'action'=>['LikesController@update', $likeId]]) !!}

            <input type="hidden" name="like" value="2">

        	<div class="form-group">
        		{!! Form::submit('Unlike', ['class'=>'btn btn-success']) !!}
        	</div>

        {!! Form::close() !!}

    @elseif($likeState == 2)
        {{--UPDATE--}}
        {!! Form::open(['method'=>'PATCH', 'action'=>['LikesController@update', $likeId]]) !!}

        <input type="hidden" name="like" value="1">

        <div class="form-group">
            {!! Form::submit('Like', ['class'=>'btn btn-success']) !!}
        </div>

        {!! Form::close() !!}

    @endif
    <br>

    <p>{{count($postLikes)}} people likes this post.</p>

    @if(count($postLikes) > 0)

        {{--Testing--}}
        <div class="container">
            {{--<h2>Likes</h2>--}}
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">See Who Liked This</button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{count($postLikes)}} likes</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tbody>
                                    @foreach($postLikes as $like)
                                        <tr>
                                            <td>{{$like->owner}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    @endif

    <hr>


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
