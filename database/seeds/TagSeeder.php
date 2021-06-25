<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'Aceptado',
            'Rechazado',
            'Repetido',
            'Por Notificar Core',
            'Por Notificar 72h',
            'Notificación Core',
            'Notificación 72h'
        ];
        foreach ($array as $tag) {
            if(!Tag::where('name',$tag)->first()){
                $newtag = new Tag();
                $newtag->name = $tag;
                $newtag->save();
            }

        }
    }
}
