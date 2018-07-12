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
    <p><B>Location: </B>{{$post->location}}</p>
    <hr>
    <p>{{$post->body}}</p>

    <br>

    <!-- Maps -->
    <div class="container">
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">See Location</button>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Route to <I style="color: #2a70e0">{{$post->location}}</I></h4>
                    </div>
                    <div class="modal-body">
                        
                        <div id="floating-panel" style="position: absolute;top: 22px;border: 1px solid #999;left: 25%;z-index: 5;background-color: #fff;padding: 5px;">
                            <b>Mode of Travel: </b>
                            <select id="mode">
                                <option value="NONE">None</option>
                                <option value="DRIVING">Driving</option>
                                <option value="WALKING">Walking</option>
                                <option value="BICYCLING">Bicycling</option>
                                <option value="TRANSIT">Transit</option>
                            </select>
                        </div>

                        <div id="right-panel" style="height: 450px;float: right;width: 165px;overflow: auto;line-height: 25px;font-family: 'Roboto','sans-serif';"></div>

                        <div id="map" style="width:390px;height:450px;"></div>
                        <script>
                            var map;
                            var infowindow;
                            var pos;
                            var destPlace;
                            var markers = [];

                            function initMap() {

                                var directionsDisplay = new google.maps.DirectionsRenderer;
                                var directionsService = new google.maps.DirectionsService;

                                var pyrmont = {lat: -33.867, lng: 151.195};
                                map = new google.maps.Map(document.getElementById('map'), {
                                    center: pyrmont,
                                    zoom: 15
                                });

                                directionsDisplay.setMap(map);
                                directionsDisplay.setPanel(document.getElementById('right-panel'));

                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(function(position) {
                                        pos = {
                                            lat: position.coords.latitude,
                                            lng: position.coords.longitude
                                        };

                                        infowindow = new google.maps.InfoWindow();
                                        markers = [];
                                        var marker1 = new google.maps.Marker({
                                            position: pos, 
                                            map: map,
                                            title: 'My Location',
                                        });
                                        markers.push(marker1);

                                        google.maps.event.addListener(marker1, 'click', function() {
                                            infowindow.setContent('My Location');
                                            infowindow.open(map, this);
                                        });

                                        var request = {
                                            query: '{{$post->location}}',
                                            fields: ['photos', 'formatted_address', 'name', 'rating', 'opening_hours', 'geometry']
                                        };
                                        var service = new google.maps.places.PlacesService(map);

                                        service.findPlaceFromQuery(request, callback);

                                        map.setCenter(pos);
                                    }, function() {
                                        handleLocationError(true, infoWindow, map.getCenter());
                                    });
                                } else {
                                    // Browser doesn't support Geolocation
                                    handleLocationError(false, infoWindow, map.getCenter());
                                }

                                calculateAndDisplayRoute(directionsService, directionsDisplay);
                                document.getElementById('mode').addEventListener('change', function() {
                                    calculateAndDisplayRoute(directionsService, directionsDisplay);
                                });
                            }

                            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                                infoWindow.setPosition(pos);
                                infoWindow.setContent(browserHasGeolocation ?
                                    'Error: The Geolocation service failed.' :
                                    'Error: Your browser doesn\'t support geolocation.');
                                infoWindow.open(map);
                            }

                            function callback(results, status) {
                              if (status == google.maps.places.PlacesServiceStatus.OK) {
                                for (var i = 0; i < results.length; i++) {
                                  var place = results[i];
                                  destPlace = place.geometry.location;
                                  createMarker(place);
                                }
                              }
                            }

                            function createMarker(place) {
                                var placeLoc = place.geometry.location;
                                var marker = new google.maps.Marker({
                                  map: map,
                                  position: place.geometry.location
                                });
                                markers.push(marker);

                                google.maps.event.addListener(marker, 'click', function() {
                                  infowindow.setContent(place.name);
                                  infowindow.open(map, this);
                                });
                            }

                            function calculateAndDisplayRoute(directionsService, directionsDisplay) {
                                for (var i = 0; i < markers.length; i++) {
                                    markers[i].setMap(null);
                                }

                                var selectedMode = document.getElementById('mode').value;
                                directionsService.route({
                                    origin: pos,
                                    destination: destPlace,
                                    travelMode: google.maps.TravelMode[selectedMode]
                                }, function(response, status) {
                                    if (status == 'OK') {
                                        directionsDisplay.setDirections(response);
                                    } else {
                                        window.alert('Directions request failed due to ' + status);
                                    }
                                });
                            }
                        </script>

                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmdUGJoHL87n5S0BzFGE2_hf6OALcPLz4&libraries=places&callback=initMap"></script>
                    </div>
                </div>

            </div>
        </div>
    </div>

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

        <button class="collapsible">See Who Liked This</button>
        <div class="contentMap">
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

        <script>
            var coll = document.getElementsByClassName("collapsible");
            var i;
            for (i = 0; i < coll.length; i++) {
              coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight){
                  content.style.maxHeight = null;
                } else {
                  content.style.maxHeight = content.scrollHeight + "px";
                } 
              });
            }
        </script>

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
