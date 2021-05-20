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
        $user->password = bcrypt('admin' );
        $user->createToken('MyAppToken')->accessToken();

        $user->save();

        $roleUser = new RoleUser();
        $roleUser-> id_user = $user->id;
        $roleUser-> id_role = 1;

        $roleUser->save();
    }
}
