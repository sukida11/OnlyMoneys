@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-3">
            @if($user->avatar)
                <img class="img-fluid" src="{{ $user->avatar->url }}" alt="">
            @else
                <img src="{{ url('storage/avatars/ava.png') }}" alt="">
            @endif
        </div>
        <div class="col-lg-6 p-3">
            <h1>{{ $user->username }} </h1>
            <p>{{ $user->email }} | {{ $user->name }}</p>
            <p class="bg-dark text-light p-3">{{ $user->bio }}</p>
        </div>
    </div>
    <hr>
    <user-component v-bind:user="{{$user}}" content_per_page="{{ \App\Models\Post::COUNT_CONTENT_PER_PAGE }}" v-bind:liked_posts="{{auth()->user()->likes}}"></user-component>
@endsection
