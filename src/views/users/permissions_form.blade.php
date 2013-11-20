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
                    ->id('superuser1')
            }}

            <legend>Generic Permissions</legend>
            @foreach( $genericPermissions as $perm)
                {{
                    Former::select("permissions[$perm]",$perm)
                        ->options(array('0' => 'Inherit','1' => 'Allow','-1' => 'Deny'))
                        ->value(array_key_exists($perm,$userPermissions) ? $userPermissions[$perm] : 0)
                        ->class('select2')
                        ->id(str_random(5))
                }}
            @endforeach
        </div>
        <div class="tab-pane" id="module">
            @if (count($modulePermissions) < 1)
                <div class="alert alert-info">
                    {{ Lang::get('cpanel::permissions.no_found') }}
                </div>
            @else
                @foreach($modulePermissions as $module)
                    <legend>{{ $module['name'] }}</legend>
                    @foreach($module['permissions'] as $perm)
                        {{
                            Former::select("permissions[$perm]",$perm)
                                ->options(array('0' => 'Inherit','1' => 'Allow','-1' => 'Deny'))
                                ->value(array_key_exists($perm,$userPermissions) ? $userPermissions[$perm] : 0)
                                ->class('select2')
                                ->id(str_random(5))
                        }}
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
</div>
