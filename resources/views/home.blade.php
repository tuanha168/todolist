@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('status_error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('status_error') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection