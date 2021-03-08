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

            [
                'title'      => 'course_access',
            ],
            [
                'title'      => 'course_create',
            ],
            [
                'title'      => 'course_edit',
            ],
            [
                'title'      => 'course_show',
            ],
            [
                'title'      => 'course_delete',
            ],

            [
                'title'      => 'slide_access',
            ],
            [
                'title'      => 'slide_create',
            ],
            [
                'title'      => 'slide_edit',
            ],
            [
                'title'      => 'slide_show',
            ],
            [
                'title'      => 'slide_delete',
            ],

            [
                'title'      => 'video_access',
            ],
            [
                'title'      => 'video_create',
            ],
            [
                'title'      => 'video_edit',
            ],
            [
                'title'      => 'video_show',
            ],
            [
                'title'      => 'video_delete',
            ],

            [
                'title'      => 'quiz_access',
            ],
            [
                'title'      => 'quiz_create',
            ],
            [
                'title'      => 'quiz_edit',
            ],
            [
                'title'      => 'quiz_show',
            ],
            [
                'title'      => 'quiz_delete',
            ],

            [
                'title'      => 'module_access',
            ],
            [
                'title'      => 'question_create',
            ],
            [
                'title'      => 'question_edit',
            ],
            [
                'title'      => 'question_show',
            ],
            [
                'title'      => 'question_delete',
            ],

            [
                'title'      => 'module_access',
            ],
            [
                'title'      => 'module_create',
            ],
            [
                'title'      => 'module_edit',
            ],
            [
                'title'      => 'module_show',
            ],
            [
                'title'      => 'module_delete',
            ]
            
        ];

        Permission::insert($permissions);
    }
}
