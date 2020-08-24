<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(App\User::class,3)->create()->each(function($user){
           for($i = 0; $i < 3; $i++){
            $user->credits()->save(factory(App\UserCredit::class)->make());
           }
           
           for($i = 0; $i < 3; $i++){
            $user->tickets()->save(factory(App\Ticket::class)->make());
           }
           
       });
    }
}
