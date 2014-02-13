<?php namespace Stevemo\Cpanel\Group\Form;

interface GroupFormInterface {

    /**
     * Create a new Group
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return Bool
     */
    public function create(array $data);

    /**
     * Update a group
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return Bool
     */
    public function update(array $data);

    /**
     * Get the validator error
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors();

} 