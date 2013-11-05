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

    /**
     * Test if validation passes before update
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function validForUpdate()
    {
        $this->rules['name'] .= ',name,' . $this->data['id'];
        return parent::passes();
    }


} 