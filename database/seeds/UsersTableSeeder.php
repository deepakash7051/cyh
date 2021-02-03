<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => "Superadmin",
            'email'     => "superadmin@swalms.com",
            'password'  => Hash::make("superadmin@123"),
            'email_verified_at' => date('Y-m-d H:i:s'),
          ]);
        User::create([
            'name'      => "Admin",
            'email'     => "admin@swalms.com",
            'password'  => Hash::make("admin@123"),
            'email_verified_at' => date('Y-m-d H:i:s'),
          ]);
    }
}
