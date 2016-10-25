<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_collection = collect([
            ['tamzida.du@gmail.com','Tamzida Sultana','secret'],
            ['azad.nmuc@gmail.com','Azad Hossain','secret']
        ]);

        while($user_item = $users_collection->pop()){
            $user = new User();
            $user->email = $user_item[0];
            $user->name = $user_item[1];
            $user->password = bcrypt($user_item[2]);
            $user->save();
            $user->roles()->attach(Role::whereAlias('support')->first()->id);
        }
    }
}
