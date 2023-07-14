<?php

namespace App\Models;

use App\Abstracts\CSVModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\SeedFromCSVTrait;

class Player extends CSVModel
{
    use HasFactory;
    use SeedFromCSVTrait;

    protected $guarded = [];
    protected $CSVName = 'players.csv';

    // map correction from csv header to database field
    protected $CSVMap = [
        'firstname' => 'first_name',
        'lastname' => 'last_name'
    ];

    /**
     * Seeds players table from CSV file
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
     * Defines player relationship to match_stats
     *
     * @return Collection
     **/
    public function matchStats()
    {
        return $this->hasMany(MatchStat::class);
    }
}
