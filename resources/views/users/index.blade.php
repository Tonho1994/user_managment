@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Usuarios') }}</div>

                <div class="card-body">
                    <users-table-component></users-table-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
