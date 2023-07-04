@extends('layouts.app')

@section('content')
<div class="container">
    <login-component password_reset_link="{{route('password.request')}}" redirect_after_login="{{route('main.index')}}"></login-component>

</div>
@endsection
