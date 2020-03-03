<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Caregiver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CaregiverController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function create(Agency $agency)
    {
        $positions = config('caregivers.positions');

        return view('caregivers.create', compact('agency', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Agency $agency)
    {
        //dd($request);
        $request->validate([
          'name'                =>  'required|regex:/^[A-Za-z\s\.-_]+$/',
          'email'               =>  'required|email|unique:caregivers',
          'position'            =>  ['required', Rule::in(config('caregivers.positions'))],
          'license_number'      =>  'required_if:position,==,Skilled Nurse|regex:',
          'license_expiration'  =>  'required_if:position,==,Skilled Nurse'
        ]);

        $input = $request->all();
        $input['agency_id'] = $agency->id;
        $caregiver = Caregiver::create($input);

        return redirect()
            ->route('agencies.show', $agency)
            ->with('status', 'Caregiver created!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agency  $agency
     * @param  \App\Caregiver  $caregiver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency, Caregiver $caregiver)
    {
        /*
            It is tipucally a good idea for us to perform soft deletes especially in healthcare applications
            however for the purpose of this task i have chosen to do just a destroy
        */
        Caregiver::findorfail($caregiver->id)->destroy($caregiver->id);

        return redirect()
            ->route('agencies.show', $agency)
            ->with('status', 'Caregiver deleted!');
    }
}
