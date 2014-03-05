@extends('cpanel::layouts')

@section('header')
<h1>Permissions</h1>
@stop

@section('breadcrumb')
@parent
<li>
    <a href="{{route('cpanel.permissions.index')}}">
        <i class="fa fa-ban"></i> Permissions
    </a>
</li>
<li class="active">Create</li>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create new permissions for a module</h3>
            </div>
            <div class="panel-body">
                <?php
                $option = array(
                    'route' => array('cpanel.permissions.update',$permission->id),
                    'class' => 'form-horizontal',
                    'method' => 'put'
                );
                ?>
                {{ Form::model($permission,$option) }}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Module Name</label>
                    <div class="col-md-4">
                        {{ Form::text('name',null,array('class'=>'form-control','placeholder'=>'Module Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Module Name</label>
                    <div class="col-md-4">
                        {{ Form::text('permissions',$permission->getRules(),
                        array('class'=>'form-control','placeholder'=>'Module Name','id'=>'permission-tags')) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop