<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MembershipDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')->insert([
                [
                    'title' => 'Standard',
                    'description' =>'Standard plan subscription.',
                    'price' => 5.99,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );
    }

}
