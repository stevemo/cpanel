@extends('cpanel::layouts.guest')

@section('content')
<div class="container register-box">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">

                    <h3 class="thin text-center">{{ trans('cpanel::registration.edit.header') }}</h3>

                    <hr>

                    @include('cpanel::partials.errors')
                    @include('flash::message')

                    {{ Form::open(['route' => 'cpanel.put_activation']) }}

                        {{ Form::hidden('token',$token) }}

                        <!--  field -->
                        <div class="form-group">
                            {{ Form::label('email',trans('cpanel::registration.edit.label')) }}
                            {{ Form::email('email',null,['class'=>'form-control']) }}
                        </div>

                        <!-- Trans('overseer::registration.activate_submit') field -->
                        <div class="form-group">
                            {{ Form::submit(trans('cpanel::registration.edit.submit'),['class'=>'btn btn-primary']) }}
                        </div>

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>
@stop