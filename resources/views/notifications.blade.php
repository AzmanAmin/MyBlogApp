@extends('layouts.app')

@section('content')

	<div class="container">
        <div class="row">
        	<div class="col-md-10">
        		<h3><B>Your Notifications</B></h3>
        		<table class="table">
        			<tbody>
        				@if($myNotification)
			        		@foreach($myNotification as $notification)
			        			<tr>
			        				<td>
			        					<a href="{{route('home.post', $notification->data['letter']['post_id'])}}">	
			        						{{$notification->data['letter']['body']}}
			        						<br>
			        						<span class="text-muted">{{$notification->created_at->diffForHumans()}}</span>
			        					</a>
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