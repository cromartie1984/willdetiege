@extends('main')

@section('title', '| Reset Password')


@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Reset Password</div>

            <div class="panel-body">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                {{ Form::open(['url' => 'password/reset','class' => 'form-horizontal']) }}

                {{ Form::hidden('token', $token) }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                     {{ Form::label('name', 'Email:', ['class' => 'col-md-4 control-label']) }}

                    <div class="col-md-6">
                       {{ Form::email('email', null, ['class' => 'form-control']) }}

                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {{ Form::label('password', 'Password:', ['class' => 'col-md-4 control-label']) }}

                    <div class="col-md-6">
                        {{ Form::password('password',  ['class' => 'form-control']) }}

                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {{ Form::label('password_confirmation', 'Confirm Password:', ['class' => 'col-md-4 control-label']) }}
                    <div class="col-md-6">
                        {{  Form::password('password_confirmation',  ['class' => 'form-control']) }}

                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        {{ Form::submit('Reset Password', array('class' => 'btn btn-primary')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
