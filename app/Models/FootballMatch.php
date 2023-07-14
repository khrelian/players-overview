<?php

namespace App\Models;

use App\Abstracts\CSVModel;
use App\Traits\SeedFromCSVTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FootballMatch extends CSVModel
{
    use HasFactory;
    use SeedFromCSVTrait;

    // cast fields to proper types
    protected $casts = ['match_date' => 'date'];

    protected $guarded = [];
    protected $CSVName = 'matches.csv';

    /**
     * Seeds football_matches from CSV file
     *
     * @return void
     **/
    public function seed(): void
    {
        $this->seedFromCSV();
    }

    /**
     * get all match dates grouped by year
     *
     *
     * @return array
     **/
    public static function getMatchDates()
    {
        return self::query()
            ->select(DB::raw('Year(match_date) as year'))
            ->groupBy('year')
            ->pluck('year');
    }


    /**
     * Relationship
     *
     * Defines the relationship to team as team1
     *
     * @return Collection
     */
    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    /**
     * Relationship
     *
     * Defines the relationship to team as team2
     *
     * @return Collection
     */
    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }
}
