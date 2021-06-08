<?php

use Illuminate\Database\Seeder;
use App\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryOne = new Category();
        $categoryOne->name = 'Activas-En Curso';
        $categoryOne->save();

        $categoryTwo = new Category();
        $categoryTwo->name = 'Histórico-Finalizadas';
        $categoryTwo->save();
    }
}
