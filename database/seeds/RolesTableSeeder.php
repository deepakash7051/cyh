<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
        	[
	            'id'         => 1,
                'slug'         => 'superadmin',
	            'title'      => 'SuperAdmin',
	        ],
            [
                'id'         => 2,
                'slug'         => 'admin',
                'title'      => 'Admin',
            ],
            [
                'id'         => 3,
                'slug'         => 'user',
                'title'      => 'User',
            ],
        ];

        Role::insert($roles);
    }
}
