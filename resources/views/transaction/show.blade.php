@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Transaction') }}</span>
                    <div>
                        <a href="{{ route('transaction.show', [$account->id, 5]) }}">
                            <button type="button" class="btn btn-primary">5</button>
                        </a>
                        <a href="{{ route('transaction.show', [$account->id, 10]) }}">
                            <button type="button" class="btn btn-primary">10</button>
                        </a>
                        <a href="{{ route('transaction.show', [$account->id, 20]) }}">
                            <button type="button" class="btn btn-primary">20</button>
                        </a>
                    </div>
                </div>
                <div class=" card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Partner ID</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction as $item)
                            <tr style="background-color: @if ($account->id === $item->sender_id)
                                #fb9696 @else #96fb9e
                            @endif">
                                <th scope=" row">{{ $loop->index }}</th>
                                <td>@if ($account->id === $item->sender_id)
                                    {{ $item->reciver_account_id }}
                                    @else
                                    {{ $item->sender_account_id }}
                                    @endif</td>
                                <td>{{ $item->message }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>@if ($account->id === $item->sender_id)
                                    -
                                    @else
                                    +
                                    @endif{{ $item->amount }} $</td>
                                <td>@if ($account->id === $item->sender_id) {{ $item->sender_balance }} @else
                                    {{ $item->reciver_balance }} @endif$</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
