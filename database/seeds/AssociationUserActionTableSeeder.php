<?php

use Illuminate\Database\Seeder;
use App\AssociationUserAction;

class AssociationUserActionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // when trying seed, possible error "Unique violation: 
        // duplicate key value violates unique constraint "association_user_actions_user_id_action_id_unique"
       factory(AssociationUserAction::Class, 20)->create();
    }
}
