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
{{--    <subscribe-component v-bind:subscribe_on="{{auth()->user()->subscribe_on}}" v-bind:profile="{{$user}}" v-bind:user="{{auth()->user()}}"></subscribe-component>--}}
    <hr>
    <user-component
        subscribers="{{ \App\Models\Subscriber::where('profile_id', $user->id)->count() }}"
        v-bind:subscribe_on="{{auth()->user()->subscribe_on}}"
        user_personal_link="{{route('personal.index')}}"
        v-bind:auth_user="{{auth()->user()}}"
        v-bind:user="{{$user}}"
        content_per_page="{{ \App\Models\Post::COUNT_CONTENT_PER_PAGE }}"
        v-bind:liked_posts="{{auth()->user()->likes}}"
        post_count="{{\App\Models\Post::where('user_id', $user->id)->count()}}"
    >
    </user-component>
@endsection
