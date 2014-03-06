@extends('cpanel::layouts')

@section('header')
<h1>Permissions</h1>
@stop

@section('breadcrumb')
@parent
<li class="active"><i class="fa fa-ban"></i> Permissions</li>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="btn-toolbar">
                        <a href="{{ URL::route('cpanel.permissions.create') }}" class="btn btn-primary"
                           data-toggle="tooltip" title="Create New permission">
                            <i class="fa fa-plus"></i>
                            New Permission
                        </a>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
                @if($permissions->isEmpty())
                    <div class="alert alert-info">
                        {{ Lang::get('cpanel::permissions.no_found') }}
                    </div>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Module</th>
                            <th>Roles</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td><h4>{{{ $permission->name }}}</h4></td>
                            <td>
                                <h4>
                                    @foreach ($permission->permissions as $role)
                                    <span class="label label-primary">{{{ $role }}}</span>
                                    @endforeach
                                </h4>
                            </td>
                            <td>
                                <a href="{{ route('cpanel.permissions.edit', array($permission->id)) }}"
                                   class="btn btn-warning" data-toggle="tooltip" title="Edit Permission">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('cpanel.permissions.destroy', array($permission->id)) }}"
                                   class="btn btn-danger" data-toggle="tooltip" title="Delete Permission" data-method="delete"
                                   data-message="delete this Permission?">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
