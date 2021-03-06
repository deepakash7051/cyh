<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
        	[
	            'title'      => 'user_management_access',
	        ],
            [
                'title'      => 'permission_create',
            ],
            [
                'title'      => 'permission_edit',
            ],
            [
                'title'      => 'permission_show',
            ],
            [
                'title'      => 'permission_delete',
            ],
            [
                'title'      => 'permission_access',
            ],

            [
                'title'      => 'role_create',
            ],
            [
                'title'      => 'role_edit',
            ],
            [
                'title'      => 'role_show',
            ],
            [
                'title'      => 'role_delete',
            ],
            [
                'title'      => 'role_access',
            ],

            [
                'title'      => 'user_create',
            ],
            [
                'title'      => 'user_edit',
            ],
            [
                'title'      => 'user_show',
            ],
            [
                'title'      => 'user_delete',
            ],
            [
                'title'      => 'user_access',
            ],

            [
                'title'      => 'category_create',
            ],
            [
                'title'      => 'category_edit',
            ],
            [
                'title'      => 'category_show',
            ],
            [
                'title'      => 'category_delete',
            ],
            [
                'title'      => 'category_access',
            ],

            
        ];

        Permission::insert($permissions);
    }
}
