@extends('cpanel::layouts')

@section('header')
<h1>Groups</h1>
@stop

@section('breadcrumb')
@parent
<li class="active"><i class="fa fa-users"></i> Groups</li>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="btn-toolbar">
                        <a href="{{ URL::route('cpanel.groups.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create New Group">
                            <i class="fa fa-plus"></i>
                            New group
                        </a>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
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
                                   class="btn btn-warning" data-toggle="tooltip" title="Edit Group">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('cpanel.groups.destroy', array($group->id)) }}"
                                   class="btn btn-danger" data-toggle="tooltip" title="Delete Group" data-method="delete"
                                   data-message="delete this group?">
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
