<?php

namespace Database\Seeders;

use App\Enums\BasicGroupEnum;
use App\Models\Basic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        #children preferences 
        Basic::create([
            'name'=>'I want Children',
            'group'=>BasicGroupEnum::children,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        Basic::create([
            'name'=>'I don\'t want Children',
            'group'=>BasicGroupEnum::children,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);


        #cleaner approach

        #education
        $values=['In College','Php','Bachelors'];
        foreach ($values as $key => $value) {
            Basic::create([
                'name'=>$value,
                'group'=>BasicGroupEnum::education,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }

          #zodiac
          $values=['Taurus','Leo','Libra'];
          foreach ($values as $key => $value) {
              Basic::create([
                  'name'=>$value,
                  'group'=>BasicGroupEnum::zodiac,
                  'created_at'=>now(),
                  'updated_at'=>now(),
              ]);
          }





    }
}
