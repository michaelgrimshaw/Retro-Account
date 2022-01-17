@extends('portal.layouts.app')

@section('page_title', trans('product.show_product'))

@section('content')
    {!! Form::open(['route' => 'portal.account.store', 'enctype'=> 'multipart/form-data', 'autocomplete' => 'off']) !!}
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4 mb-4">Create your account</h1>
            </div>
            <div class="col-md-4">
                <div class="mt-4 mb-4 float-end">
                    <a class="btn btn-card me-2" href="{{ route('portal.account.index') }}">
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
                                <label for="for_name" class="required">Account Name</label>
                                <input type="text" name="name" id="for_name" value="{{ old('name', $account->name) }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="for_goal" class="required">Set your financial goal</label>
                                <input type="number" step="0.01" name="goal" id="for_goal" value="{{ old('goal') }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="for_balance" class="required">Initial Deposit</label>
                                <input type="number" step="0.01" name="balance" id="for_balance" value="{{ old('balance') }}" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop
