<?php

use Illuminate\Database\Seeder;
use App\User;
use App\RoleUser;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user-> name = 'admin';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('admin');

        $user->save();

        $roleUser = new RoleUser();
        $roleUser->user_id = $user->id;
        $roleUser->role_id = 1;

        $roleUser->save();
    }
}
