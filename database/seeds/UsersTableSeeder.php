<?php

use Illuminate\Database\Seeder;
use App\Action;
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
        factory(User::class,10)->create()
        ->each(function($user){ for ($i=0; $i <2 ; $i++) { 
            $user->initiatedActions()->save(factory(Action::class)->create());
        }
            });
    }
}
