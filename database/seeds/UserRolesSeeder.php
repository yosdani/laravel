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
        if(!Role::where('name', 'Admin')->first()){
            //create Admin role
            $role = new Role();
            $role ->name = 'Admin';
            $role ->save();
        }
        if(!Role::where('name', 'Responsable')->first()){
            //create Responsable role
            $role = new Role();
            $role ->name = 'Responsable';
            $role ->save();
        }
        if(!Role::where('name', 'Trabajador')->first()){
            //create Worker role
            $role = new Role();
            $role ->name = 'Trabajador';
            $role ->save();
        }

    }
}
