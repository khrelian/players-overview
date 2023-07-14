<?php

namespace Database\Seeders;

use App\Models\MatchStat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatchStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MatchStat::truncate();
        (new MatchStat())->seed();
    }
}
