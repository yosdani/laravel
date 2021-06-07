<?php

use Illuminate\Database\Seeder;
use App\User;
use App\RoleUser;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

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

        $token_user = JWTAuth::fromUser( $user );

        $user->token_user = $token_user;

        $user->save();

        $roleUser = new RoleUser();
        $roleUser->user_id = $user->id;
        $roleUser->role_id = 1;

        $roleUser->save();
    }
}
