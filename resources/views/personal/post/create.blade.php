@extends('layouts.app')

@section('content')

    <div class="row p-3">

        <images-component redirect_link_after_create_post="{{ route('personal.index') }}"></images-component>
    </div>



@endsection
