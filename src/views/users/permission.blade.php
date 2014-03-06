@extends('cpanel::layouts')

@section('header')
<h1>Users Permissions</h1>
@stop

@section('breadcrumb')
@parent
<li>
    <a href="{{route('cpanel.users.index')}}">
        <i class="fa fa-user"></i>
        Users
    </a>
</li>
<li class="active">Permissions</li>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit {{ $user->first_name }}&nbsp;{{ $user->last_name }}&nbsp;permissions</h3>
            </div>
            <div class="panel-body">
                <?php
                $option = array(
                    'route' => array('cpanel.users.permissions',$user->id),
                    'method' => 'put',
                    'class' => 'form-horizontal'
                );
                ?>
                {{ Form::open($option) }}
                @include('cpanel::users.permissions_form')
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
                {{ form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection