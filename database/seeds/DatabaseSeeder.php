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
        // $this->call(UserSeeder::class);
        $this->call(RolesTableSeeder::class);
        // $this->call(AddInfoUserSeeder::class);
        $this->call(UsersDataSeeder::class);
        $this->call(MembershipDataSeeder::class);
    }
}
