<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ["create","update","delete","read"];
        for($i=0;$i<10;$i++){
            DB::table('lisans_takip.logs')->insert([
                "type" => $types[array_rand($types)],
                'title' => Str::random(24),
                'description' => Str::random(55),
                "new_data" => Str::random(300),
                "old_data" =>  Str::random(450),
                "adminId" => 1
            ]);
        }

    }
}
