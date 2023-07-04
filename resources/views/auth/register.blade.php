@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <registration-component redirect_link_after_registration="{{route('verification.notice')}}"></registration-component>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
