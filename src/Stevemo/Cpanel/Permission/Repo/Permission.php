<?php  namespace Stevemo\Cpanel\Permission\Repo;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

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
     * Mutator for giving permissions.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $permissions
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     *
     */
    public function getPermissionsAttribute($permissions)
    {
        if (is_array($permissions))
        {
            return $permissions;
        }

        if ( ! $permissions)
        {
            return array();
        }

        if ( ! $_permissions = json_decode($permissions, true))
        {
            throw new \InvalidArgumentException("Cannot JSON decode permissions [$permissions].");
        }

        return $_permissions;
    }

    /**
     * convert permissions into a comma separated string and remove the prefix
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return string
     */
    public function getRules()
    {
        $perm = $this->permissions;
        $data = array();

        foreach ($perm as $val)
        {
            list($prefix,$data[]) = explode('.', $val);
        }

        return implode(',',$data);
    }

    /**
     * Mutator for Module name
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  string $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * Mutator for taking permissions.
     *
     * @author   Steve Montambeault
     * @link     http://stevemo.ca
     *
     * @param $permissions
     *
     * @return void
     */
    public function setPermissionsAttribute($permissions)
    {
        $module = lcfirst($this->attributes['name']);

        $roles = array();

        //prefix the permission with the module name ex: user.create
        foreach ($permissions as $key => $value)
        {
            $roles[] = $module . '.' . $value;
        }

        $this->attributes['permissions'] = ( ! empty($roles)) ? json_encode($roles) : '';
    }
} 