<?php

use App\Milestone;
use Illuminate\Database\Seeder;

class MilestoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Milestone::create([
            'user_id'      => "1",
            'title'     => "Kick Off",
            'price'  => '',
            'type' => 'fixed',
            'order' => 1,
        ]);

        Milestone::create([
            'user_id'      => "1",
            'title'     => "Down Payment",
            'price'  => '40',
            'type' => 'percentage',
            'order' => 2,
        ]);

        Milestone::create([
            'user_id'      => "1",
            'title'     => "Materials Fabrication Done",
            'price'  => '40',
            'type' => 'percentage',
            'order' => 3,
        ]);

        Milestone::create([
            'user_id'      => "1",
            'title'     => "Upon Installation",
            'price'  => '10',
            'type' => 'percentage',
            'order' => 4,
        ]);

        Milestone::create([
            'user_id'      => "1",
            'title'     => "Upon Completetion",
            'price'  => '10',
            'type' => 'percentage',
            'order' => 5,
        ]);
    }
}
