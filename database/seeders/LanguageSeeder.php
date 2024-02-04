<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $languages = ['english','turkish','dutch','russian','chinese','finish','fillipino','french'];
        foreach ($languages as $key => $value) {

            Language::create([
                'name'=>$value
            ]);
        }
    }
}
