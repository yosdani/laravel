<?php

use App\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'Baja',
            'Media',
            'Alta'
        ];
        foreach ($array as $priority) {
            if(!Priority::where('name',$priority)->first()){
                $newp = new Priority();
                $newp->name = $priority;
                $newp->save();
            }

        }
    }
}
