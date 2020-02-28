<?php

namespace App\Http\Controllers;

use App\Agency;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //since the model already has the relationship we can use withCount to get
        //the count of each relationship. 
        $agencies = Agency::withCount(['caregivers'])->orderBy('name')->paginate(20);
        return view('agencies.index', compact('agencies'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {
        return view('agencies.show', compact('agency'));
    }
}
