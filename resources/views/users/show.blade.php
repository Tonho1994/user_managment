@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <users-edit-component :user='@json($user)' user-edit-route="{{ route('users.update',$user->id) }}"></users-edit-component>
        </div>
    </div>
</div>
@endsection