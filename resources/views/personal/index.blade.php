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
            <h1>{{ $user->username }} <br>@if(!$user->email_verified_at)
                    <span class="text-danger"><a class="" href="{{route('personal.email')}}">Подтвердить электронную почту</a></span>
                @endif
            </h1>
            <p>{{ $user->email }} | {{ $user->name }}</p>
            <p class="bg-dark text-light p-3">{{ $user->bio }}</p>
            <p><a href="{{ route('personal.edit') }}" class="btn btn-outline-secondary">Настройки</a>
                &nbsp;<a href="{{ route('personal.subs.index') }}" class="btn btn-outline-primary">Подписки</a></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <a href="{{ route('personal.post.create') }}" class="btn btn-outline-secondary w-100">Новый пост</a>
    </div>
    <hr>
    <index-post-component post_count="{{\App\Models\Post::where('user_id', auth()->user()->id)->count()}}" v-bind:user="{{auth()->user()}}" edit_link_without_id="/personal/posts/edit/" content_per_page="{{\App\Models\Post::COUNT_CONTENT_PER_PAGE}}"></index-post-component>
@endsection
