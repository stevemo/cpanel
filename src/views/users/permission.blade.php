@extends('cpanel::layouts')

@section('header')
    <h3>
        <i class="icon-user"></i>
        Users Permissions
    </h3>
@stop

@section('content')
    {{Former::horizontal_open( route('admin.users.permissions', [$user->id]), 'PUT' )}}
    <div class="row">
        <div class="span12">
            <div class="block">
                <p class="block-heading">{{ $user->first_name }} Permissions | Permissions set here will override groups permissions</p>
                <div class="block-body">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#generic" data-toggle="tab">Generic Permissions</a></li>
                        <li><a href="#module" data-toggle="tab">Modules Permissions</a></li>
                    </ul>
                     
                    <div class="tab-content">
                        <div class="tab-pane active" id="generic">
                            <legend>Super User <small>Access Everything</small></legend>
                            {{ Former::select('rules[superuser]','Super User')
                                ->options(array('0' => 'No','1' => 'Yes'))
                                ->value($user->isSuperUser() ? 1 : 0)
                                ->class('select2')
                            }}
                            @foreach( $genericPerm as $perm)
                                <legend>Generic Permissions</legend>
                                @foreach( $perm['permissions'] as $input )
                                    {{ Former::select($input['name'],$input['text'])
                                        ->options(array('0' => 'Deny', '1' => 'Allow'))
                                        ->value($input['value'])
                                        ->class('select2')->id($input['id'])
                                    }}
                                @endforeach
                            @endforeach
                        </div>
                        <div class="tab-pane" id="module">
                            @foreach( $modulePerm as $perm)
                                <legend>{{ $perm['name'] }} Module</legend>
                                @foreach( $perm['permissions'] as $input )
                                    {{ Former::select($input['name'],$input['text'])
                                        ->options(array('0' => 'Deny', '1' => 'Allow'))
                                        ->value($input['value'])
                                        ->class('select2')->id($input['id'])
                                    }}
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{route('admin.users.index')}}" class="btn">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Former::close() }}
@stop

