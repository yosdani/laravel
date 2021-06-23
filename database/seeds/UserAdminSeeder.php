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
        if (!User::where('email', 'admin@example.com')->first()) {
            $user = new User();
            $user-> name = 'admin';
            $user->email = 'admin@example.com';
            $user->password = bcrypt('admin');

            $token_user = JWTAuth::fromUser($user);

            $user->token_user = $token_user;

            $user->save();

            $roleUser = new RoleUser();
            $roleUser->user_id = $user->id;
            $roleUser->role_id = 1;

            $roleUser->save();
        }

        $workers = [
            [
                'name' => 'trabajador',
                'email' => 'trabajador@example.com',
                'password' => bcrypt('trabajador')
            ],
            [
                'name' => 'trabajador1',
                'email' => 'trabajador1@example.com',
                'password' => bcrypt('trabajador1')
            ],
            [
                'name' => 'trabajador2',
                'email' => 'trabajador2@example.com',
                'password' => bcrypt('trabajador2')
            ]
        ];

        foreach( $workers as $worker ){
            if( !User::where( 'email', '=', $worker['email'] )->first() ){
                //worker role
                $user = new User();
                $user->name = $worker['name'];
                $user->email = $worker['email'];
                $user->password = $worker['password'];

                $token_user = JWTAuth::fromUser($user);

                $user->token_user = $token_user;

                $user->save();

                $roleUser = new RoleUser();
                $roleUser->user_id = $user->id;
                $roleUser->role_id = 3;

                $roleUser->save();
            }
        }

        if (!User::where('email', 'trabajador@example.com')->first()) {
            //worker role
            $user = new User();
            $user->name = 'trabajador';
            $user->email = 'trabajador@example.com';
            $user->password = bcrypt('trabajador');

            $token_user = JWTAuth::fromUser($user);

            $user->token_user = $token_user;

            $user->save();

            $roleUser = new RoleUser();
            $roleUser->user_id = $user->id;
            $roleUser->role_id = 3;

            $roleUser->save();
        }

        if (!User::where('email', 'responsable@example.com')->first()) {
            //worker role
            $user = new User();
            $user->name = 'responsable';
            $user->email = 'responsable@example.com';
            $user->password = bcrypt('responsable');

            $token_user = JWTAuth::fromUser($user);

            $user->token_user = $token_user;

            $user->save();

            $roleUser = new RoleUser();
            $roleUser->user_id = $user->id;
            $roleUser->role_id = 2;

            $roleUser->save();
        }
    }
}
