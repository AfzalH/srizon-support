<?php

use App\Role;
use App\Ticket;
use App\Ticketpost;
use App\Ticketstatus;
use App\User;
use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $i = 100;
        while($i--) {
            $user_id = $this->create_or_get_user();
            $ticket = new Ticket;
            $ticket->title = $faker->realText(50);
            $ticket->ticketcategory_id = \App\Ticketcategory::all()->random()->id;
            $ticket->product_id = \App\Product::all()->random()->id;
            $ticket->secret = str_random();
            $ticket->user_id = $user_id;
            $ticket->email_code = str_random(5);
            $ticket->ticketstatus_id = TicketStatus::all()->random()->id;
            $ticket->save();

            $totalpost = rand(2,10);
            while($totalpost--) {
                $post = new Ticketpost;
                $flip = rand(0,1);
                if($flip) {
                    $post->user_id = $user_id;
                }
                else{
                    $post->user_id = rand(1,3);
                }
                $post->body = $faker->realText();
                $ticket->ticketposts()->save($post);
            }
        }
    }

    public function create_or_get_user(){
        $faker = \Faker\Factory::create();
        $email = $faker->email;
        if(User::whereEmail($email)->count() == 0){
            $user = new User;
            $user->name = $faker->name;
            $user->password = bcrypt(str_random());
            $user->email = $email;
            $user->save();
            if(Role::whereAlias('customer')->count()){
                $user->assignRole('customer');
            }
            return $user->id;
        }
        else{
            return User::whereEmail($email)->first()->id;
        }
    }
}
