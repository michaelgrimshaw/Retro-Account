@extends('portal.layouts.app')

@section('page_title', 'Your Accounts')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4 mb-4">Welcome, {{ $user->first_name }}</h1>

            </div>
            <div class="col-md-4">
                <div class="mt-4 mb-4 float-end">
                    <a class="btn btn-card me-2" href="{{ route('portal.account.create') }}">
                        <i class="material-icons">&#xE145;</i>
                    </a>
                    <a class="btn btn-card" href="{{ route('portal.logout') }}">
                        <i class="material-icons">lock</i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <dl class="dl-horizontal">
                        <dt>Account Holder</dt>
                        <dd>{{ $user->name }}</dd>

                        <dt>Email</dt>
                        <dd>{{ $user->email }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Account</th>
                            <th>Ref.</th>
                            <th>Balance</th>
                            <th>Arranged Overdraft</th>
                            <th>Goal</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->reference }}</td>
                                <td>{{ format_money($account->balance) }}</td>
                                <td>{{ format_money($account->overdraft) }}</td>
                                <td>{{ format_money($account->goal) }}</td>
                                <td>
                                    <a class="" href="{{ route('portal.account.show', $account) }}">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
