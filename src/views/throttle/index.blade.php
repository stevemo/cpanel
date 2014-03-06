@extends('cpanel::layouts')

@section('header')
<h1> Users Throttling</h1>
@stop

@section('breadcrumb')
@parent
<li>
    <a href="{{route('cpanel.users.index')}}">
        <i class="fa fa-user"></i>
        Users
    </a>
</li>
<li class="active">Throttling</li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $user->first_name }}&nbsp; {{ $user->last_name }} Throttling Status</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($throttle->isBanned())
                    <tr>
                        <td><strong>Ban Status</strong></td>
                        <td>This is user is Banned</td>
                        <td>
                            <a href="{{ route('cpanel.users.throttling.update',array($user->id,'unban')) }}"
                               class="btn btn-primary" rel="tooltip" title="UnBan User"
                               data-method="put" data-message="Unban this user?">
                                <i class="fa fa-check"></i>
                                Unban User
                            </a>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td><strong>Ban Status</strong></td>
                        <td>This is user is not Banned</td>
                        <td>
                            <a href="{{ route('cpanel.users.throttling.update',array($user->id,'ban')) }}"
                               class="btn btn-danger" rel="tooltip" title="Ban User"
                               data-method="put" data-message="Ban this user?">
                                <i class="fa fa-ban"></i>
                                Ban User
                            </a>
                        </td>
                    </tr>
                    @endif

                    @if ($throttle->isSuspended())
                    <tr>
                        <td><strong>Suspension status</strong></td>
                        <td>This user is suspended</td>
                        <td>
                            <a href="{{ route('cpanel.users.throttling.update',array($user->id,'unsuspend')) }}"
                               class="btn btn-primary" rel="tooltip" title="UnBan User"
                               data-method="put" data-message="Unsuspend this user?">
                                <i class="fa fa-check"></i>
                                Unsuspend User
                            </a>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td><strong>Suspension status</strong></td>
                        <td>This user is not suspended</td>
                        <td>
                            <a href="{{ route('cpanel.users.throttling.update',array($user->id,'suspend')) }}"
                               class="btn btn-danger" rel="tooltip" title="Ban User"
                               data-method="put" data-message="Suspend this user?">
                                <i class="fa fa-ban"></i>
                                Suspend User
                            </a>
                        </td>
                    </tr>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@stop