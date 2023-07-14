@extends('layouts.app')

@section('content')

    <main-component
        v-bind:subscribe_on="{{auth()->user()->subscribe_on}}"
        user_personal_link="{{route('personal.index')}}"
        v-bind:auth_user="{{auth()->user()}}"
        content_per_page="{{ \App\Models\Post::COUNT_CONTENT_PER_PAGE }}"
        v-bind:liked_posts="{{auth()->user()->likes}}"
        post_count="{{\App\Models\Post::count()}}"
    >
    </main-component>

@endsection
