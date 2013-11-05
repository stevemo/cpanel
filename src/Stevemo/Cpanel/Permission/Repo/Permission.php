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
} 