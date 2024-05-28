@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <hire-component cv-route="{{ route('cv') }}"></hire-component>
            </div>
        </div>
    </div>
</div>
@endsection

