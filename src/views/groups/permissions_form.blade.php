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
            <div class="form-group">
                <label for="permissions[$perm]" class="col-sm-2 control-label">{{$perm}}</label>
                <div class="col-md-2">
                    {{
                        Form::select(
                        "permissions[$perm]",
                        array('1' => 'Allow','0' => 'Deny'),
                        array_key_exists($perm,$groupPermissions) ? $groupPermissions[$perm] : 0,
                        array('class'=>'select2 form-control','id'=>str_random(5)))
                    }}
                </div>
            </div>
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
                    <div class="form-group">
                        <label for="permissions[$perm]" class="col-sm-2 control-label">{{$perm}}</label>
                        <div class="col-md-2">
                            {{
                            Form::select(
                            "permissions[$perm]",
                            array('1' => 'Allow','0' => 'Deny'),
                            array_key_exists($perm,$groupPermissions) ? $groupPermissions[$perm] : 0,
                            array('class'=>'select2 form-control','id'=>str_random(5)))
                            }}
                        </div>
                    </div>
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
</div>
