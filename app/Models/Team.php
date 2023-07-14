<?php

namespace App\Models;

use App\Abstracts\CSVModel;
use App\Traits\SeedFromCSVTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends CSVModel
{
    use HasFactory;
    use SeedFromCSVTrait;

    protected $guarded = [];
    protected $CSVName = 'teams.csv';

    /**
     * Seeds teams table from csv file
     *
     * @return void
     **/
    public function seed(): void
    {
        $this->seedFromCSV();
    }

    /**
     * Relationship
     *
     * Defines relationship to match_stats table
     *
     * @return Collection
     **/
    public function matchStats()
    {
        return $this->hasMany(MatchStat::class);
    }

    /**
     * Relationship
     *
     * Defines relationship to football_matches table as team 1
     *
     * @return Collection
     **/
    public function footballMatchAsTeam1()
    {
        return $this->hasMany(FootballMatch::class, 'team1_id');
    }


    /**
     * Relationship
     *
     * Defines relationship to football_matches table as team 1
     *
     * @return Collection
     **/
    public function footballMatchAsTeam2()
    {
        return $this->hasMany(FootballMatch::class, 'team2_id');
    }
}
