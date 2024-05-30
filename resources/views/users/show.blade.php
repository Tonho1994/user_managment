@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <users-edit-component :user='@json($user)' user-route="{{ route('users.index') }}"></users-edit-component>
        </div>
    </div>
</div>
@endsection