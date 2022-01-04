<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $users = ['info' , 'user1', 'user2'];
      foreach ($users as $key => $name) {

        $check_user = DB::table('users')->where('email', $name.'@grabtheaux.com')->first();
        if($check_user){
            $this->command->info('User data already added');
        }
        else{

                $user =   DB::table('users')->insert(
                      [
                          'first_name' => $name.'@grabtheaux.com',
                          'last_name' => $name,
                          'email' => $name.'@grabtheaux.com',
                          'phone' => '123456789',
                          'password' => bcrypt('123123123'),
                          'email_verified_at' => Carbon::now(),
                          'created_at' => Carbon::now(),
                          'updated_at' => Carbon::now()
                      ]
                  );
                  if($name == 'info'){
                    $admin_role = DB::table('roles')->where('name' , 'Software-admin')->first();
                    $user = DB::table('users')->where('email', 'info@grabtheaux.com')->first();
                    DB::table('model_has_roles')->insert(
                        [
                            'role_id' => $admin_role->id,
                            'model_type' => 'App\User',
                            'model_id'=> $user->id
                        ]

                    );
                  }
                  if($name == 'user1'){
                    $user_role = DB::table('roles')->where('name' , 'User')->first();
                    $user = DB::table('users')->where('email', 'user1@grabtheaux.com')->first();
                    DB::table('model_has_roles')->insert(
                        [
                            'role_id' => $user_role->id,
                            'model_type' => 'App\User',
                            'model_id'=> $user->id
                        ]

                    );
                  }
                  if($name == 'user2'){
                    $user_role = DB::table('roles')->where('name' , 'User')->first();
                    $user = DB::table('users')->where('email', 'user2@grabtheaux.com')->first();
                    DB::table('model_has_roles')->insert(
                        [
                            'role_id' => $user_role->id,
                            'model_type' => 'App\User',
                            'model_id'=> $user->id
                        ]

                    );
                  }
            }

      }


    }

}
