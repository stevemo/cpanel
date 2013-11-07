<p class="lead">Permissions set here will override groups permissions</p>
<div class="tabbable">

    <ul class="nav nav-pills" id="tabPermission">
        <li class="active">
            <a href="#generic" data-toggle="tab">Generic Permissions</a>
        </li>
        <li>
            <a href="#module" data-toggle="tab">Modules Permissions</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="generic">
            <legend>Super User <small>Access Everything</small></legend>
            {{
                Former::select('permissions[superuser]','Super User')
                    ->options(array('0' => 'No','1' => 'Yes'))
                    ->value($user->isSuperUser() ? 1 : 0)
                    ->class('select2')
            }}
            @foreach( $genericPermissions as $perm)
                <legend>Generic Permissions</legend>
                @foreach( $perm['permissions'] as $input )
                    {{
                        Former::select($input['name'],$input['text'])
                            ->options(array('0' => 'Inherit','1' => 'Allow','-1' => 'Deny'))
                            ->value($input['value'])
                            ->class('select2')
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
                                ->options(array('0' => 'Inherit','1' => 'Allow','-1' => 'Deny'))
                                ->value($input['value'])
                                ->class('select2')
                        }}
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
</div>