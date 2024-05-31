@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <users-table-component get-users-route="{{ route('api.users.get') }}" user-route="{{ route('users.index') }}"></users-table-component>
        </div>
    </div>
</div>
@endsection