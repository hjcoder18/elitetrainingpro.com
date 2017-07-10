@extends('layouts.default')

@section('title', '| Home')

@section('stylesheets')
	<link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset('assets/css/header.css') }}"></link>
	<link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset('assets/css/homepage.css') }}"></link>
@endsection

@section('navlinks')
	<li><a href="home"><i class="fa fa-home fa"></i>Athletes</a></li>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>Welcome {{ Auth::user()->name }}</h1>

				<div id="ProfilePage">
				    <div id="LeftCol">
				        <div id="Photo"> <img src="{{ URL::asset('assets/avatars/uploads/' . $bio->image) }}" alt="No image found" height="200px" width="200px"> </div>
				    </div>

				    <div id="Info">
				       <p>
			        		<strong>Role</strong>
			        		<span>{{ $bio->identity }}</span>
			        	</p>
				        <p>
				            <strong>Email:</strong>
							<span>{{ $bio->email }}</span>
						</p>
						<p>
							<strong>City, State:</strong>
							<span>{{ $bio->city }}, {{ $bio->state }}</span>
						</p>
						<p>
							<strong>About Me:</strong>
							<span>{{ substr(strip_tags($bio->bio),0, 300) }}{{ strlen(strip_tags($bio->bio)) > 150 ? "..." : ""}}</span>
				        </p>
				    </div>
				    <!-- Elements inside ProfilePage have floats -->
				    <div style="clear:both"></div>
				</div>

				<div id="athlete">
					@if(count($athletes)>=1)
					<h3>Your Athlete(s):</h3>
					<?php $index = sizeof($athletes)-count($athletes); ?>
					@foreach(array_reverse($athletes) as $athlete)
					<div class="col-md-6">
						<div id="Profile">
							<div id="Lefts">
								<div><h4><strong>{{ $athlete[$index]->name }}</strong></h4></div><br/>
								<div id="Photo"> <img src="{{ URL::asset('assets/avatars/uploads/' . $athlete[$index]->image) }}" alt="No image found" height="80px" width="80px"> </div><br/>
								
							</div>

							<div id="Infos">
								@if($athlete[$index]->still_connected == 0)
									<p><form style="display:inline-block" action="connectRequest" method="post">
										<input type="hidden" name="email" value="{{ $athlete[$index]->email }}"> {!! csrf_field() !!}
										<button type="submit" name="accept_submit" value="accept_submit" id="accept_submit" class="btn btn-success">Accept Athlete</button>
									</form> 
									<form style="display:inline-block" action="connectRequest" method="post">
										<input type="hidden" name="email" value="{{ $athlete[$index]->email }}"> {!! csrf_field() !!}
										<button type="submit" name="Deny" value="deny" id="deny_submit" class="btn btn-danger"> Deny Athlete</button>
									</form></p>
								@else
									<p>{!! Form::open(['route' => 'coachcalendar.store', 'data-parsley-validate' => '', 'files' => true, 'style'=>'display:inline-block']) !!}
									{{ Form::hidden('email',  $athlete[$index]->email) }}
									{{ Form::submit('View Athlete', ['class' => 'btn btn-primary']) }}
									{!! Form::close() !!}
									<form style="display:inline-block" action="connectRequest" method="post">
										<input type="hidden" name="email" value="{{ $athlete[$index]->email }}"> {!! csrf_field() !!}
										<button type="submit" name="Deny" value="deny" id="deny_submit" class="btn btn-danger">Remove</button>
									</form></p>
								@endif

								<p><span> {{ $athlete[$index]->email }} </span></p>
								<p><span> {{ $athlete[$index]->city }}, {{ $athlete[$index]->state }} </span></p>
								<p> <span> {{ substr(strip_tags($athlete[$index]->bio),0, 300) }}{{ strlen(strip_tags($bio->bio)) > 150 ? "..." : "" }} </span></p>

							</div>
							<div style="clear:both"></div>
						</div>
					</div>
					@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
