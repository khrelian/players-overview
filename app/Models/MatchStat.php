<?php

namespace App\Models;

use App\Abstracts\CSVModel;
use App\Traits\SeedFromCSVTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatchStat extends CSVModel
{
    use HasFactory;
    use SeedFromCSVTrait;

    protected $guarded = [];
    // name of the csv file
    protected $CSVName = 'match_stats.csv';
    // map of csv header to database field name
    protected $CSVMap = ['match_id' => 'football_match_id'];

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
     * get stats params and id
     *
     * @return array
     **/
    public static function getParams()
    {
        return self::query()
            ->select('param_name', 'param_id')
            ->groupBy('param_name', 'param_id')
            ->pluck('param_name', 'param_id');
    }


    /**
     * Relationship
     *
     * Defines relationship to players table
     *
     * @return Collection
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Relationship
     *
     * Defines relationship to teams table
     *
     * @return Collection
     **/
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Relationship
     *
     * Defines relationship to football_matches table
     *
     * @return Collection
     **/
    public function footballMatch()
    {
        return $this->belongsTo(FootballMatch::class);
    }



    /**
     * Scope
     *
     * Filters record by statistics and year
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function scopeFilter(Builder $query, $param_id, $yr)
    {
        $query->select(
            'match_stats.player_id',
            'match_stats.param_name',
            DB::raw('SUM(match_stats.value) as total_value')
        )->whereHas('footballMatch', function ($query) use ($yr) {
            $query->whereYear('match_date', $yr);
        })
            ->where('param_id', $param_id)
            ->groupBy('match_stats.player_id', 'match_stats.param_name')
            ->orderByRaw('total_value DESC');
    }
}
