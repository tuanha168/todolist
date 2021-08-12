@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Profile') }}</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#EditProfileModal">Edit Profile</button>
                </div>
                <div class=" card-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <span class="form-control border-0">{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <span class="form-control border-0">{{ $user->email }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone_number"
                            class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                        <div class="col-md-6">
                            <span class="form-control border-0">{{ $user->profile->phone_number }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

                        <div class="col-md-6">
                            <span
                                class="form-control border-0">{{ $user->profile->dob ? date('d/m/Y', strtotime($user->profile->dob)) : '' }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                        <div class="col-md-6">
                            <span class="form-control border-0">{{ $user->profile->address }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pin_number"
                            class="col-md-4 col-form-label text-md-right">{{ __('Pin Number') }}</label>

                        <div class="col-md-6">
                            <span class="form-control border-0">******</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="EditProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/profiles/{{ Auth::user()->id }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Profile') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') ?? $user->name }}" required autocomplete="name"
                                    autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <span class="form-control border-0">{{ $user->email }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number"
                                class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="tel"
                                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                    value="{{ old('phone_number') ?? $user->profile->phone_number }}"
                                    autocomplete="phone_number">

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dob"
                                class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

                            <div class="col-md-6">
                                <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror"
                                    name="dob" value="{{ old('dob') ?? $user->profile->dob }}" autocomplete="dob">

                                @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address"
                                class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text"
                                    class="form-control @error('address') is-invalid @enderror" name="address"
                                    value="{{ old('address') ?? $user->profile->address }}" autocomplete="address">

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="pin_number"
                                class="col-md-4 col-form-label text-md-right">{{ __('Pin Number') }}</label>

                            <div class="col-md-6">
                                <input id="pin_number" type="password"
                                    class="form-control @error('pin_number') is-invalid @enderror" name="pin_number"
                                    value="{{ old('pin_number') ?? $user->pin_number }}" autocomplete="pin_number">

                                @error('pin_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Edit') }}
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@if ($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('EditProfileModal'), {
        keyboard: false
    })
    myModal.show()
</script>
@endif

@endsection
