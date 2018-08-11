<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $user_id = [1,2,3];
        $faker = app(Faker\Generator::class);

        $statuses = factory(\App\Models\Status::class)->times(100)->make()->each(function($status)use($faker,$user_id){
            $status->user_id = $faker->randomElement($user_id);
        });

        \App\Models\Status::insert($statuses->toArray());
    }
}
