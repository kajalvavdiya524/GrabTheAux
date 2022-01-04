<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class AddInfoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = DB::table('roles')->where('name' , 'Software-admin')->first();
        $user = DB::table('users')->where('email', 'info@grabtheaux.com')->first();

        if($user){
            $has_role = DB::table('model_has_roles')->where('model_id', $user->id)
                                        ->where('role_id', $admin_role->id)->first();

            if($has_role){
                $this->command->info('Info User Has Already Admin Role');
            }else{
                DB::table('model_has_roles')->insert(
                    [
                        'role_id' => $admin_role->id,
                        'model_type' => 'App\User',
                        'model_id'=> $user->id
                    ]

                );
                $this->command->info('Assign Admin Role to Info User');
            }

        }else{
          $user =  DB::table('users')->insert(
                [
                    'first_name' => 'info@grabtheaux.com',
                    'last_name' => 'admin',
                    'email' => 'info@grabtheaux.com',
                    'phone' => '123456789',
                    'password' => bcrypt('123123123'),
                    'email_verified_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );
            $user =  DB::table('users')->where('email', 'info@grabtheaux.com')->first();
           if($user){
            DB::table('model_has_roles')->insert(
                [
                    'role_id' => $admin_role->id,
                    'model_type' => 'App\User',
                    'model_id'=> $user->id
                ]

            );
           }
        }

    }
}
