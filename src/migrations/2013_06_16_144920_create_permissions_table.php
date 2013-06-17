<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->text('permissions');
			$table->timestamps();
		});
        $this->seed();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permissions');
	}

    /**
     * Create default Permissions
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    public function seed()
    {
        DB::table('permissions')->insert(array(
            array(
                'name' => 'Admin',
                'permissions' => json_encode(array('admin.view')),
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ),
            array(
                'name' => 'Users',
                'permissions' => json_encode(array('users.view','users.create','users.update','users.delete')),
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ),
            array(
                'name' => 'Groups',
                'permissions' => json_encode(array('groups.view','groups.create','groups.update','groups.delete')),
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ),
            array(
                'name' => 'Permissions',
                'permissions' => json_encode(array('permissions.view','permissions.create','permissions.update','permissions.delete')),
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            )
        ));


    }

}
