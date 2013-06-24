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
    From here you can Ban, unban, suspend or unsuspend a single user.
</p>
@stop

@section('content')

<div class="row">
    <div class="span12">

        <div class="block">
            <p class="block-heading">{{ $user->first_name }}&nbsp; {{ $user->last_name }} Throttling Status</p>

            <div class="block-body">




                @if ($throttle->isBanned())
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="{{ asset('packages/stevemo/cpanel/img/not-ok-icon.png') }}" alt=""/>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">Banned</h4>
                            <p>
                                <a href="{{ route('admin.users.throttling.update',array($user->id,'unban')) }}"
                                   class="btn btn-primary" rel="tooltip" title="UnBan User"
                                   data-method="put" data-modal-text="Unban this user?">
                                    <i class="icon-check"></i>
                                    Unban User
                                </a>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="{{ asset('packages/stevemo/cpanel/img/ok-icon.png') }}" alt=""/>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">Not Banned</h4>
                            <p>
                                <a href="{{ route('admin.users.throttling.update',array($user->id,'ban')) }}"
                                   class="btn btn-danger" rel="tooltip" title="Ban User"
                                   data-method="put" data-modal-text="Ban this user?">
                                    <i class="icon-ban-circle"></i>
                                    Ban User
                                </a>
                            </p>
                        </div>
                    </div>
                @endif

                @if ($throttle->isSuspended())
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ asset('packages/stevemo/cpanel/img/not-ok-icon.png') }}" alt=""/>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Suspended</h4>
                        <p>
                            <a href="{{ route('admin.users.throttling.update',array($user->id,'unsuspend')) }}"
                               class="btn btn-primary" rel="tooltip" title="UnBan User"
                               data-method="put" data-modal-text="Unsuspend this user?">
                                <i class="icon-check"></i>
                                Unsuspend User
                            </a>
                        </p>
                    </div>
                </div>
                @else
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ asset('packages/stevemo/cpanel/img/ok-icon.png') }}" alt=""/>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Not Suspended</h4>
                        <p>
                            <a href="{{ route('admin.users.throttling.update',array($user->id,'suspend')) }}"
                               class="btn btn-danger" rel="tooltip" title="Ban User"
                               data-method="put" data-modal-text="Suspend this user?">
                                <i class="icon-ban-circle"></i>
                                Suspend User
                            </a>
                        </p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@stop