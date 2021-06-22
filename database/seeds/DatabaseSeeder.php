<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(UserAdminSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TagsSeeder::class);
        $this->call(StateSeeder::class);
    }
}
