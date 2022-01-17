@extends('portal.layouts.app')

@section('page_title', trans('product.show_product'))

@section('content')
    {!! Form::open(['route' => ['portal.account.transaction.store', $account], 'enctype'=> 'multipart/form-data', 'autocomplete' => 'off']) !!}
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4 mb-4">Make a transaction</h1>
            </div>
            <div class="col-md-4">
                <div class="mt-4 mb-4 float-end">
                    <a class="btn btn-card me-2" href="{{ route('portal.account.show', $account) }}">
                        <i class="material-icons">&#xE31B;</i>
                    </a>
                    <button class="btn btn-card me-2">
                        <i class="material-icons">&#xE161;</i>
                    </button>
                    <a class="btn btn-card" href="{{ route('portal.logout') }}">
                        <i class="material-icons">lock</i>
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {!! implode('', $errors->all('<div class="">:message</div>')) !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="for_name" class="required">Transaction Type</label>
                                {{ Form::select('transaction_type_id', \App\Transaction\Models\TransactionType::all()->pluck('name', 'id') , null , ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="for_transaction_date" class="required">Transaction Date</label>
                                <input type="text" name="transaction_date" id="for_transaction_date" value="{{ old('transaction_date') }}" class="form-control datepicker" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="for_description" class="required">Description</label>
                                <input type="text" name="description" id="for_description" value="{{ old('description') }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="for_value" class="required">Value to transfer</label>
                                <input type="number" step="0.01" name="value" id="for_value" value="{{ old('value') }}" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop
