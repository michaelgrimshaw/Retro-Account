@extends('portal.layouts.app')

@section('page_title', trans('product.show_product'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4 mb-4">Welcome, Michael</h1>

            </div>
            <div class="col-md-4">
                <div class="mt-4 mb-4 float-end">
                    <a class="btn btn-card me-2">
                        <i class="material-icons">&#xE31B;</i>
                    </a>
                    <a class="btn btn-card">
                        <i class="material-icons">&#xE145;</i>
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

                        <dt>Available Balance</dt>
                        <dd>£{{ number_format($account->balance, 2) }}</dd>

                        <dt>Balance without pending transactions</dt>
                        <dd>£{{ number_format($account->balance_without_pending, 2) }}</dd>

                        <dt>Arranged Overdraft</dt>
                        <dd>£{{ number_format($account->overdraft, 2) }}</dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <dl class="dl-horizontal">
                        <dt>Account Holder</dt>
                        <dd>£2.99</dd>

                        <dt>Email</dt>
                        <dd>£2.99</dd>

                        <dt>Balance without pending transactions</dt>
                        <dd>£2.99</dd>

                        <dt>Arranged Overdraft</dt>
                        <dd>£2.99</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="for_name" class="required">Name</label>
                                <input type="text" name="name" id="for_name" value="{{ old('name') }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="for_name" class="required">Name</label>
                                <input type="text" name="name" id="for_name" value="{{ old('name') }}" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Transaction Date</th>
                                <th>Reference</th>
                                <th>Amount</th>

                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($account->transactions as $transaction)
                            <tr>
                                <td>a</td>
                                <td>b</td>
                                <td>c</td>
                                <td>d</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
