@extends('cpanel::layouts')

@section('header')
    <h1>Users</h1>
@stop

@section('breadcrumb')
    @parent
    <li class="active"><i class="fa fa-user"></i> Users</li>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="btn-toolbar">
                            <a href="{{ route('cpanel.users.create') }}" class="btn btn-primary"
                               data-toggle="tooltip" title="Create New User">
                                <i class="fa fa-plus"></i>
                                New User
                            </a>
                        </div>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="hidden-xs">Email</th>
                            <th class="hidden-xs">Active</th>
                            <th class="hidden-xs">Joined</th>
                            <th class="hidden-xs">Last Visit</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ HTML::linkRoute('cpanel.users.show',$user->first_name.' '.$user->last_name, array($user->id)) }}</td>
                            <td class="hidden-xs">{{{ $user->email }}}</td>
                            <td class="hidden-xs">{{{ ($user->activated) ? 'yes' : 'no' }}}</td>
                            <td class="hidden-xs">{{{ $user->activated_at }}}</td>
                            <td class="hidden-xs">{{{ is_null($user->last_login) ? 'Never Visited' : $user->last_login }}}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                        Action
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('cpanel.users.show', array($user->id)) }}">
                                                <i class="fa fa-info-circle"></i>&nbsp;View User
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('cpanel.users.edit', array($user->id)) }}">
                                                <i class="fa fa-edit"></i>&nbsp;Edit User
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('cpanel.users.permissions', array($user->id)) }}">
                                                <i class="fa fa-ban"></i>&nbsp;Permissions
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('cpanel.users.destroy', array($user->id)) }}"
                                               data-method="delete"
                                               data-message="delete this User?">
                                                <i class="fa fa-trash-o"></i>&nbsp;Delete User
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            @if ($user->isActivated())
                                            <a href="{{ route('cpanel.users.deactivate', array($user->id)) }}"
                                               data-method="put"
                                               data-message="Deactivate this User?">
                                                <i class="fa fa-minus-circle"></i>&nbsp;Deactivate
                                            </a>
                                            @else
                                            <a href="{{ route('cpanel.users.activate', array($user->id)) }}"
                                               data-method="put"
                                               data-message="Activate this User?">
                                                <i class="fa fa-check"></i>&nbsp;Activate
                                            </a>
                                            @endif
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ route('cpanel.users.throttling', array($user->id)) }}">
                                                <i class="fa fa-key"></i>&nbsp;Throttling
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
