<?php

use Illuminate\Database\Seeder;

class GlosariumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Glosarium::class,1)->create()->each(function($p){
          $p->save();
        });
    }
}
