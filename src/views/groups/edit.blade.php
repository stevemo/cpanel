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

{{ Former::horizontal_open(route('cpanel.groups.update', array($group->id)))->method('PUT') }}
    <div class="row">
        <div class="span12">
            <div class="block">
                <p class="block-heading">Edit "{{ $group->name }}" Group</p>
                <div class="block-body">
                    {{ Former::xlarge_text('name','Name')->value($group->name)->required() }}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{route('cpanel.groups.index')}}" class="btn">Cancel</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="span12">
            <div class="block">
                <p class="block-heading">Group Permissions</p>
                <div class="block-body">

                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#generic" data-toggle="tab">Generic Permissions</a></li>
                        <li><a href="#module" data-toggle="tab">Modules Permissions</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="generic">
                            @foreach( $genericPermissions as $perm)
                                <legend>Generic Permissions</legend>
                                @foreach( $perm['permissions'] as $input )
                                    {{
                                        Former::select($input['name'],$input['text'])
                                        ->options(array('0' => 'Deny', '1' => 'Allow'))
                                        ->value($input['value'])
                                        ->class('select2')
                                        ->id($input['id'])
                                    }}
                                @endforeach
                            @endforeach
                        </div>
                        <div class="tab-pane" id="module">
                            @if (count($modulePermissions) < 1)
                            <div class="alert alert-info">
                                {{ Lang::get('cpanel::permissions.no_found') }}
                            </div>
                            @else
                                @foreach( $modulePermissions as $perm)
                                <legend>{{ $perm['name'] }} Module</legend>
                                    @foreach( $perm['permissions'] as $input )
                                        {{
                                            Former::select($input['name'],$input['text'])
                                            ->options(array('0' => 'Deny', '1' => 'Allow'))
                                            ->value($input['value'])
                                            ->class('select2')
                                            ->id($input['id'])
                                        }}
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{route('cpanel.groups.index')}}" class="btn">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{ Former::close() }}

@stop
