<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\FootballMatch;
use App\Models\MatchStat;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    /**
     * Index
     *
     * Overview index view
     *
     * @param Request $request url get request params
     * @return view
     *
     **/
    public function index(Request $request)
    {
        $params = MatchStat::getParams();
        $matchDates = FootballMatch::getMatchDates();

        return view('pages.overview.index')
            ->with('params', $params)
            ->with('matchDates', $matchDates);
    }

    /**
     * Search
     *
     * Filters football players with the highest value for each param_id grouped by year.
     *
     * @param SearchRequest $request Description
     * @return view
     **/
    public function search(SearchRequest $request)
    {
        $page = $request->input('page', 1);
        $data = MatchStat::filter($request->statistic, $request->year)
            ->with('footballMatch')
            ->with('player')
            ->paginate(10, ['*'], 'page', $page);

        return view('sections.table')->with('data', $data)->with('year', $request->year);
    }
}
