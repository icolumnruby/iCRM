<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();   //delete permissions table records
        DB::table('permissions')->insert(array(
            array(
                'name'        => 'admin',
                'slug'        => '{"create":true,"view":true,"update":true,"delete":true}',
                'description' => 'manage admin'
            ),
            array(
                'name'        => 'company',
                'slug'        => '{"create":true,"view":true,"update":true,"delete":true}',
                'description' => 'manage company'
            ),
            array(
                'name'        => 'branch',
                'slug'        => '{"create":true,"view":true,"update":true,"delete":true}',
                'description' => 'manage branch'
            ),
            array(
                'name'        => 'member',
                'slug'        => '{"create":true,"view":true,"update":true,"delete":true}',
                'description' => 'manage members'
            ),
            array(
                'name'        => 'product.category',
                'slug'        => '{"create":true,"view":true,"update":true,"delete":true}',
                'description' => 'manage product categories'
            ),
            array(
                'name'        => 'transaction',
                'slug'        => '{"create":true,"view":true,"update":true,"delete":true}',
                'description' => 'manage transactions'
            )
        ));
    }
}
