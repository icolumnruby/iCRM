<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->delete();   //delete roles table records
        DB::table('roles')->insert(array(
            array(
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'Manage administration privileges'
            ),
            array(
                'name' => 'Branch Manager',
                'slug' => 'manager',
                'description' => 'Manage branches and staffs'
            ),
            array(
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Manage members'
            )
        ));
    }
    
}
