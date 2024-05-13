<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $genres = Config::get('genres');
        foreach ($genres as $genre) {
            DB::table('genres')->insert([
                'name_en' => $genre['en'],
                'name_ka' => $genre['ka']
            ]);
        }

    }

}
