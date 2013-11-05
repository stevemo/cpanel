<?php  namespace Stevemo\Cpanel\Permission\Form;

use Stevemo\Cpanel\Services\Validation\AbstractValidator;

class PermissionValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'name'        => 'required|unique:permissions',
        'permissions' => 'required'
    );
} 