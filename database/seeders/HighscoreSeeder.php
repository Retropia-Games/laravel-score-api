<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Highscore;
use Illuminate\Support\Str;

class HighscoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = DB::table('projects')->first("id");

        for ($i = 0; $i < 50; $i++) {
            DB::table('highscores')->insert([
                'project_id' => $project->id,
                'nickname' => Str::random(10),
                'score' => rand(100, 9999),
                'source' => "seeder",
            ]);
        }
    }
}
