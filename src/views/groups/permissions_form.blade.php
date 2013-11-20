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

            <legend>Generic Permissions</legend>
            @foreach( $genericPermissions as $perm)
                {{
                    Former::select("permissions[$perm]",$perm)
                        ->options(array('1' => 'Allow','0' => 'Deny'))
                        ->value(array_key_exists($perm,$groupPermissions) ? $groupPermissions[$perm] : 0)
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
                                ->options(array('1' => 'Allow','0' => 'Deny'))
                                ->value(array_key_exists($perm,$groupPermissions) ? $groupPermissions[$perm] : 0)
                                ->class('select2')
                                ->id(str_random(5))
                        }}
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
</div>
