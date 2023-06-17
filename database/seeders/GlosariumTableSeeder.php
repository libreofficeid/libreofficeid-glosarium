<?php

namespace Database\Seeders;

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
        \App\Models\Glosarium::factory(1)->create()->each(function($p){
          $p->save();
        });
    }
}
