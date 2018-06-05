@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-10">

                <h1>Posts</h1>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Photo</th>
                        <th>Owner</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($posts)
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->id}}</td>
                                <td><img height="50" src="{{$post->photo ? $post->photo->file : '/images/contract.png'}}"></td>
                                <td>{{$post->user->name}}</td>
                                <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
                                <td>{{$post->title}}</td>
                                <td>{{str_limit($post->body, 20)}}</td>
                                <td>{{$post->created_at->diffForHumans()}}</td>
                                <td>{{$post->updated_at->diffForHumans()}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>

        </div>

    </div>

@endsection