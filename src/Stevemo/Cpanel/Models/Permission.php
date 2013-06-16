<?php namespace Stevemo\Cpanel\Models;

use Eloquent;

class Permission extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','permissions');

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Mutator for taking name
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @param  string $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * Mutator for taking permissions.
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @param  array $permissions_arr 
     * @return string
     */
    public function setPermissionsAttribute($permissions)
    {
        $module = lcfirst($this->attributes['name']);
        //prefix the permission with the module name ex: user.create

        $roles = array();
        foreach ($permissions as $key => $value) 
        {
            $roles[] = $module . '.' . $value;
        }

        $this->attributes['permissions'] = ( ! empty($roles)) ? json_encode($roles) : '';
    }

    /**
     * Mutator for giving permissions.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     * 
     * @param  mixed  $permissions
     * @return array  $_permissions
     */
    public function getPermissionsAttribute($permissions)
    {
        if ( ! $permissions)
        {
            return array();
        }

        if (is_array($permissions))
        {
            return $permissions;
        }

        if ( ! $_permissions = json_decode($permissions, true))
        {
            throw new \InvalidArgumentException("Cannot JSON decode permissions [$permissions].");
        }

        return $_permissions;
    }

    /**
     * Format rules for checkbox in form
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @return array 
     */
    public function getRulesAttribute()
    {
        $roles = array();
        foreach ($this->permissions as $role) 
        {
            list($module, $rule) = explode('.', $role);
            $roles[] = $rule;
        }
        return $roles;
        //{{ Former::checkboxes('permissions')->checkboxes($permission->permissionsForm)->label('Permissions')->required() }}
    }

}