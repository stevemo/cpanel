@extends(Config::get('cpanel::views.layout'))

@section('header')
<h3>
    <i class="icon-key"></i>
    Users Throttling
</h3>
@stop

@section('help')
<p class="lead">Users Throttling</p>
<p>
    From here you can ban, unban, suspend or unsuspend a single user.
</p>
@stop

@section('content')

<div class="row">
    <div class="span12">

        <div class="block">
            <p class="block-heading">{{ $user->first_name }}&nbsp; {{ $user->last_name }} Throttling Status</p>

            <div class="block-body">

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
                        <tr class="error">
                            <td><strong>Ban Status</strong></td>
                            <td>This is user is Banned</td>
                            <td>
                                <a href="{{ route('cpanel.users.throttling.update',array($user->id,'unban')) }}"
                                   class="btn btn-primary" rel="tooltip" title="UnBan User"
                                   data-method="put" data-modal-text="Unban this user?">
                                    <i class="icon-check"></i>
                                    Unban User
                                </a>
                            </td>
                        </tr>
                    @else
                    <tr class="success">
                        <td><strong>Ban Status</strong></td>
                        <td>This is user is not Banned</td>
                        <td>
                            <a href="{{ route('cpanel.users.throttling.update',array($user->id,'ban')) }}"
                               class="btn btn-danger" rel="tooltip" title="Ban User"
                               data-method="put" data-modal-text="Ban this user?">
                                <i class="icon-ban-circle"></i>
                                Ban User
                            </a>
                        </td>
                    </tr>
                    @endif

                    @if ($throttle->isSuspended())
                        <tr class="error">
                            <td><strong>Suspension status</strong></td>
                            <td>This user is suspended</td>
                            <td>
                                <a href="{{ route('cpanel.users.throttling.update',array($user->id,'unsuspend')) }}"
                                   class="btn btn-primary" rel="tooltip" title="UnBan User"
                                   data-method="put" data-modal-text="Unsuspend this user?">
                                    <i class="icon-check"></i>
                                    Unsuspend User
                                </a>
                            </td>
                        </tr>
                    @else
                        <tr class="success">
                            <td><strong>Suspension status</strong></td>
                            <td>This user is not suspended</td>
                            <td>
                                <a href="{{ route('cpanel.users.throttling.update',array($user->id,'suspend')) }}"
                                   class="btn btn-danger" rel="tooltip" title="Ban User"
                                   data-method="put" data-modal-text="Suspend this user?">
                                    <i class="icon-ban-circle"></i>
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