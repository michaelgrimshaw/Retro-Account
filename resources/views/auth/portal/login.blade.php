@extends('portal.layouts.app')

@section('page_title', 'Login')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-5">
                    <form method="POST" action="{{ route('portal.login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="email" class="required">Email</label>
                            <input id="email" type="email" class="form-control" name="email" />
                        </div>

                        <div class="form-group">
                            <label for="password" class="required">Password</label>
                            <input id="password" type="password" class="form-control" name="password">
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-card btn-block">
                            Login
                        </button>

{{--                        <hr />--}}

{{--                        <a class="btn btn-card btn-block" href="{{ route('portal.password.request') }}">--}}
{{--                            Forgot Your Password--}}
{{--                        </a>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
