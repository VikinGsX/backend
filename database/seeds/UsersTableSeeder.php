<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // factory(App\User::class, 3)->create()->each(function ($user) {
        //     $user->socials()->save(factory(App\Social::class)->make());
        // });

        \App\User::create([
            'name'=> 'ChengChe',
            'email'=> 'ttxtt001@gmail.com',
            'mobile'=> '0988768643',
            'password'=> bcrypt('a96629411aa'),
            'platform' => 'web',
            'station' => 'backend.test',
        ]);

        // factory(App\User::class, 3)->create();








    }
}
