<?php

use App\Role;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create Admin role
       $role = new Role();
       $role ->name = 'Admin';
       $role ->save();

       //create Responsable role
       $role = new Role();
       $role ->name = 'Responsable';
       $role ->save();

    }
}
