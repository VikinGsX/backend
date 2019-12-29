<?php

use Illuminate\Database\Seeder;

class SocialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//         factory(App\Social::class, 50)->create()->each(function ($user) {
//             $user->socials()->save(factory(App\Social::class)->make());
//         });


         \App\Social::create([
            'name'=> '楊珈萱',
            'email'=> 'sally012120@gmail.com',
            'password'=> bcrypt('VikinGsX74500X'),
            'provider'=> 'Google',
            'provider_user_id' => '110168909595422140125',
            'avatar' => 'https://lh3.googleusercontent.com/a-/AAuE7mDyRas-CoaxkHtaL-TUeH3BcgvAuBSL1FqiKsMi',
        ]);

        // factory(App\Social::class, 9)->create();

    }
}
