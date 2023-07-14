@extends('layouts.app')

@section('content')
    <div class="w-50">
        <form action="{{ route('personal.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row">
            <h3>Аватар</h3>
            @if($user->avatar)
                <div class="col-lg-6">
                    <img class="img-fluid" src="{{ $user->avatar->url }}" alt="">
                    <p class="mt-3">
                        <input type="file" class="form-control" name="avatar">
                        @error('avatar')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </p>
                </div>
                @else
                <img src="{{ url('storage/avatars/ava.png') }}" alt="">
                <p><input type="file" class="form-control" name="avatar"></p>
            @endif
        </div>
            <div class="row">
                <p class="form-group">
                <input type="text" class="form-control w-50" value="{{ $user->username }}" name="username" placeholder="Никнэйм">
                </p>
                @error('username')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
                <p class="form-group">
                    <input type="text" class="form-control w-50" value="{{ $user->name }}" name="name" placeholder="Никнэйм">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </p>
                <p class="form-group">
                    <input type="email" class="form-control w-50" value="{{ $user->email }}" name="email" placeholder="Никнэйм">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </p>
                <p>
                    <textarea name="bio" id="bio" placeholder="bio" class="form-control" cols="30" rows="10">{{$user->bio}}</textarea>
                </p>

                <p>
                    <input type="submit" value="Сохранить" class="btn btn-outline-success">
                </p>
            </div>
        </form>
        <hr>
        <a href="{{route('password.request')}}">Сменить пароль</a>
        <hr>
    </div>
@endsection
