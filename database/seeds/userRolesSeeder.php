<?php

use Illuminate\Database\Seeder;
use App\userRoles;

class userRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create Admin role
       $role = new userRoles();
       $role -> name = 'Admin';
       $role -> save();

       //create Responsable role
       $role = new UserRoles();
       $role -> name = 'Responsable';
       $role -> save();
       
    }
}
