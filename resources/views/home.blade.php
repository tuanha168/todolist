@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Bank Accounts') }}
                    <div>
                        @if ($user->otp)
                        <button type="button" class="btn btn-danger mr-3" data-toggle="modal"
                            data-target="#otp">OTP</button>
                        @endif
                        <button {{ count($user->account) < 1 ? 'hidden' : '' }} type="button"
                            class="btn btn-danger mr-3" data-toggle="modal" data-target="#Transfers">Transfers</button>
                        <button {{ count($user->account) < 1 ? 'hidden' : '' }} type="button"
                            class="btn btn-danger mr-3" data-toggle="modal" data-target="#Deposit">Deposit</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#NewAccountModal">New Account</button>
                    </div>
                </div>

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
                    @if (count($user->account) < 1) <p>Please Create A Bank Account</p>
                        @else
                        <ul class="nav nav-tabs" id="bankList" role="tablist">
                            @foreach ($user->account as $item)
                            <li class="nav-item" role="presentation">
                                <button class="{{ $loop->first ? 'nav-link active' : 'nav-link' }}"
                                    id="{{ str_replace(' ', '-', $item->account_name) }}-tab" data-toggle="tab"
                                    data-target="{{ '#' . str_replace(' ', '-', $item->account_name) }}" type="button"
                                    role="tab" aria-controls="{{ str_replace(' ', '-', $item->account_name) }}"
                                    aria-selected="true">{{ $item->account_name }}</button>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="accountContent">
                            @foreach ($user->account as $item)
                            <div class="{{ $loop->first ? 'tab-pane fade show active' : 'tab-pane fade' }}"
                                id="{{ str_replace(' ', '-', $item->account_name) }}" role="tabpanel"
                                aria-labelledby="{{ str_replace(' ', '-', $item->account_name) }}-tab">
                                <ul class="list-group list-group-flush mt-2">
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Account ID</span>
                                            <span>{{ $item->account_id }}</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Account Type</span>
                                            <button type="button" disabled
                                                class="{{ $item->account_type === 'normal' ? 'btn btn-outline-primary' : 'btn btn-outline-success' }}">{{ $item->account_type === 'normal' ? 'Normal Account' : 'Saving Account' }}</button>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Account Balance</span>
                                            <span>{{ $item->balance }}$</span>
                                        </div>
                                    </li>
                                </ul>
                                <div class="text-right mt-3">
                                    <a href="{{ route('transaction.show', $item) }}">
                                        <button type="button" class="btn btn-primary">Transaction</button>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="NewAccountModal" tabindex="-1" aria-labelledby="NewAccountLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('account.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="NewAccountLabel">{{ __('Create New Bank Account') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="account_name"
                                class="col-md-4 col-form-label text-md-right">{{ __('Account Name') }}</label>

                            <div class="col-md-6">
                                <input id="account_name" type="text"
                                    class="form-control @error('account_name') is-invalid @enderror" name="account_name"
                                    required autofocus />

                                @error('account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="account_type"
                                class="col-md-4 col-form-label text-md-right">{{ __('Account Type') }}</label>

                            <div class="col-md-6">
                                <select aria-label="Default select"
                                    class="form-select form-control @error('account_type') is-invalid @enderror"
                                    name="account_type" required>
                                    <option selected value="normal">Normal Account</option>
                                    <option value="saving">Saving Account</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="Deposit" tabindex="-1" aria-labelledby="DepositLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('account.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DepositLabel">{{ __('Deposit') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="account_id"
                                class="col-md-4 col-form-label text-md-right">{{ __('Account') }}</label>

                            <div class="col-md-6">
                                <select aria-label="Default select"
                                    class="form-select form-control @error('account_id') is-invalid @enderror"
                                    name="account_id" required>
                                    @foreach ($user->account as $item)
                                    <option {{ $loop->first ? 'selected' : '' }} value="{{ $item->id }}">
                                        {{ $item->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="balance"
                                class="col-md-4 col-form-label text-md-right">{{ __('Balance') }}</label>

                            <div class="col-md-6">
                                <input id="balance" type="number"
                                    class="form-control @error('balance') is-invalid @enderror" name="balance" required
                                    autofocus />

                                @error('balance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="pin_number_deposit"
                                class="col-md-4 col-form-label text-md-right">{{ __('Pin Number') }}</label>

                            <div class="col-md-6">
                                <input id="pin_number_deposit" type="password"
                                    class="form-control @error('pin_number_deposit') is-invalid @enderror" required
                                    name="pin_number_deposit" />

                                @error('pin_number_deposit')
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
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="Transfers" tabindex="-1" aria-labelledby="DepositLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('transaction.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DepositLabel">{{ __('Transfers') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="account_id"
                                class="col-md-4 col-form-label text-md-right">{{ __('Account') }}</label>

                            <div class="col-md-6">
                                <select aria-label="Default select"
                                    class="form-select form-control @error('account_id') is-invalid @enderror"
                                    value="{{ old('account_id') }}" name="account_id" required>
                                    @foreach ($user->account as $item)
                                    <option {{ $loop->first ? 'selected' : '' }} value="{{ $item->id }}">
                                        {{ $item->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reciver_account_id"
                                class="col-md-4 col-form-label text-md-right">{{ __('Transfers To') }}</label>

                            <div class="col-md-6">
                                <input id="reciver_account_id" type="text"
                                    class="form-control @error('reciver_account_id') is-invalid @enderror"
                                    value="{{ old('reciver_account_id') }}" name="reciver_account_id" required
                                    autofocus />

                                @error('reciver_account_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

                            <div class="col-md-6">
                                <input id="amount" type="number"
                                    class="form-control @error('amount') is-invalid @enderror" name="amount" required
                                    value="{{ old('amount') }}" autofocus />

                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pin_number_tranfers"
                                class="col-md-4 col-form-label text-md-right">{{ __('Pin Number') }}</label>

                            <div class="col-md-6">
                                <input id="pin_number_tranfers" type="password"
                                    class="form-control @error('pin_number_tranfers') is-invalid @enderror" required
                                    name="pin_number_tranfers" />

                                @error('pin_number_tranfers')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="message"
                                class="col-md-4 col-form-label text-md-right">{{ __('Message') }}</label>

                            <div class="col-md-6">
                                <textarea row="3" id="message" type="text" class="form-control"
                                    value="{{ old('amount') }}" name="message"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="otp" tabindex="-1" aria-labelledby="DepositLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('transaction.confirm') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DepositLabel">{{ __('OTP') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-success" role="alert">
                            Your OTP is {{ $user->otp }}
                        </div>

                        <div class="form-group row">
                            <label for="otp_number"
                                class="col-md-4 col-form-label text-md-right">{{ __('OTP Number') }}</label>

                            <div class="col-md-6">
                                <input id="otp_number" type="text"
                                    class="form-control @error('otp_number') is-invalid @enderror" required
                                    name="otp_number" />

                                @error('otp_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($errors->has('account_name'))
<script>
    var myModal = new bootstrap.Modal(document.getElementById('NewAccountModal'), {
        keyboard: false
    })
    myModal.show()
</script>
@elseif ($errors->has('pin_number_deposit'))
<script>
    var myModal = new bootstrap.Modal(document.getElementById('Deposit'), {
        keyboard: false
    })
    myModal.show()
</script>
@elseif ($errors->has('pin_number_tranfers') || $errors->has('amount') || $errors->has('reciver_account_id'))
<script>
    var myModal = new bootstrap.Modal(document.getElementById('Transfers'), {
        keyboard: false
    })
    myModal.show()
</script>
@elseif ($errors->has('otp_number') || $user->otp)
<script>
    var myModal = new bootstrap.Modal(document.getElementById('otp'), {
        keyboard: false
    })
    myModal.show()
</script>
@endif
@endsection
