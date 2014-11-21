@extends('main')

@section('content')
	<p> {{ e($user->username)}} deneme login  ({{ e($user->email)}})  </p>

	@stop