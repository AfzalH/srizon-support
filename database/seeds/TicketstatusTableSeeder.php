<?php

use App\Ticketstatus;
use Illuminate\Database\Seeder;

class TicketstatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status_array = collect([
            ['Closed','default'],
            ['Resolved','success'],
            ['Verify','primary'],
            ['Need Info','danger'],
            ['Open','warning'],
            ['New [Mod]','info'],
            ['New','info'],
        ]);
        while ($status_element = $status_array->pop()) {
            $status = new Ticketstatus();
            $status->name = $status_element[0];
            $status->class = $status_element[1];
            $status->save();
        }
    }
}
