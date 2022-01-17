@extends('portal.layouts.app')

@section('page_title', 'Account | ' . $account->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4 mb-4">Account | {{ $account->name }}</h1>

            </div>
            <div class="col-md-4">
                <div class="mt-4 mb-4 float-end">
                    <a class="btn btn-card me-2" href="{{ route('portal.account.index') }}">
                        <i class="material-icons">&#xE31B;</i>
                    </a>
                    <a class="btn btn-card me-2" href="{{ route('portal.account.transaction.create', $account) }}">
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
                        <dt>Account</dt>
                        <dd>{{ $account->name }}</dd>

                        <dt>Reference</dt>
                        <dd>{{ $account->reference }}</dd>

                        <dt>Available Balance</dt>
                        <dd>{{ format_money($account->available_balance) }}</dd>

                        <dt>Balance without pending transactions</dt>
                        <dd>{{ format_money($account->balance) }}</dd>

                        <dt>Arranged Overdraft</dt>
                        <dd>{{ format_money($account->overdraft) }}</dd>

                        <dt>My Goals</dt>
                        <dd>{{ format_money($account->goal) }}</dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <canvas id="myChart" width="400" height="400" style="margin: 0 100px"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 class="mt-4 mb-4">Pending Transactions</h3>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><i class="material-icons">compare_arrows</i></th>
                            <th>Transaction Date</th>
                            <th>Reference</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($account->transactions()->isPending()->orderBy('created_at', 'desc')->orderBy('transaction_date', 'desc')->get() as $transaction)
                            <tr>
                                <td><i class="material-icons">{{ $transaction->type == 'Deposits' ? 'chevron_right' : 'chevron_left' }}</i></td>
                                <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                                <td>{{ $transaction->reference }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td>{{ format_money($transaction->value) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 class="mt-4 mb-4">Transactions</h3>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><i class="material-icons">compare_arrows</i></th>
                                <th>Transaction Date</th>
                                <th>Reference</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($account->transactions()->isProcessed()->orderBy('created_at', 'desc')->orderBy('transaction_date', 'desc')->get() as $transaction)
                            <tr>
                                <td><i class="material-icons">{{ $transaction->type == 'Deposits' ? 'chevron_right' : 'chevron_left' }}</i></td>
                                <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                                <td>{{ $transaction->reference }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td>{{ format_money($transaction->value) }}</td>
                                <td>{{ $transaction->latestTransactionEvent->name }}</td>
                                <td>{{ format_money($transaction->balance) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_javascript')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                        'Savings',
                        // 'Blue',
                        'Goal'
                    ],
                    datasets: [{
                        data: [{{ $data }}],
                        backgroundColor: [
                            'rgba(73, 73, 73, 0.7)',
                            'rgba(73, 73, 73, 0.1)',
                            'rgba(73, 73, 73, 1)'
                        ],
                        hoverOffset: 4
                    }],
                }
            });
        });
    </script>
@stop
