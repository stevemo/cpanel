@extends('cpanel::layouts.guest')
@section('content')
<div class="container register-box">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="thin text-center">{{{ trans('cpanel::registration.success.header') }}}</h3>
                    <p class="">{{{ trans('cpanel::registration.success.first') }}}</p>
                    <p class="">{{{ trans('cpanel::registration.success.second') }}}</p>
                    <p class="text-muted">{{{ trans('cpanel::registration.success.third') }}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop