<?php

use Illuminate\Database\Seeder;
use App\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'En Proceso',
            'Finalizadas'
        ];
        foreach ($array as $tag) {
            if(!State::where('name',$tag)->first()){
                $newtag = new State();
                $newtag->name = $tag;
                $newtag->save();
            }

        }
    }
}
