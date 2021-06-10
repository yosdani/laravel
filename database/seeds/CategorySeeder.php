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
        $categoryOne->name = 'Categoria 1';
        $categoryOne->save();

        $categoryTwo = new Category();
        $categoryTwo->name = 'Categoria 2';
        $categoryTwo->save();
    }
}
