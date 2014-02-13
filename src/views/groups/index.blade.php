@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-group"></i>
        Groups
    </h3>
@stop

@section('help')
    <p class="lead">Groups</p>
    <p>
        Users can be placed into groups to manage permissions.
    </p>
    <br>
     <p class="text-info">
        For more info visit <a href="http://docs.cartalyst.com/sentry-2/permissions" target="_blank">Sentry website</a>
    </p>
@stop

@section('content')
    <div class="row">
        <div class="span12">
            <div class="block">
                <p class="block-heading">Groups</p>
                <div class="block-body">
                    <div class="btn-toolbar">
                        <a href="{{ URL::route('cpanel.groups.create') }}" class="btn btn-primary" rel="tooltip" title="Create New Group">
                            <i class="icon-plus"></i>
                            New group
                        </a>
                    </div>
                    @if (count($groups) == 0)
                        <div class="alert alert-info">
                            {{ Lang::get('cpanel::groups.no_group') }}
                        </div>
                    @else
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th class="span4"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($groups as $group)
                            <tr>
                                <td>{{{ $group->name }}}</td>
                                <td>
                                    <a href="{{ route('cpanel.groups.edit', array($group->id)) }}"
                                        class="btn" rel="tooltip" title="Edit Group">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <a href="{{ route('cpanel.groups.destroy', array($group->id)) }}"
                                        class="btn btn-danger" rel="tooltip" title="Delete Group" data-method="delete"
                                        data-modal-text="delete this group?">
                                        <i class="icon-remove"></i>
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
