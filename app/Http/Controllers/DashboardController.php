<?php

namespace App\Http\Controllers;

use App\Caregiver;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {

        $caregiver_position_count = Caregiver::groupBy('position')
                                          ->selectRaw('position, count(*) as total')
                                          ->get()->toArray();
        $caregiver_totals = array_column($caregiver_position_count, 'position', 'total');

        $caregivers_exp_soonest = Caregiver::where([
            ['license_expiration', '>', date('Y-m-d')],
            ['position', '=', 'Skilled Nurse']])
            ->orderBy('license_expiration', 'asc')
            ->take(10)
            ->get();

        return view('dashboard', compact('caregiver_totals', 'caregivers_exp_soonest'));
    }
}
