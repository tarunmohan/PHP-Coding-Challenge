<?php

use App\Caregiver;
use App\Mail\LicenseExpiring;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/


/**
 * List all skilled nurse license details.
 */
Artisan::command('licenses:list', function () {
    //list all caregivers with a licence to the console
    // Requirement was to list license detail, so I assume we also wanted the license number on the screen
    $headers = ['License Owner', 'License Expiry Date', 'License Number'];
    $caregivers = Caregiver::whereNotNull('license_number')->get(['name','license_expiration', 'license_number']);
    $this->table($headers, $caregivers);

})->describe('List all skilled nurse license details');


/**
 * Notify nurses with licenses expiring soon.
 */
Artisan::command('licenses:notify-expiring-soon', function () {
    //query all caregivers not just skilled nurses for license expiration
    $caregivers = Caregiver::whereNotNull('email')
            ->whereRaw('DATEDIFF(license_expiration,now()) < ?')
            ->setBindings([config('caregivers.license_renewal_reminder_in_days')])
            ->get();

    foreach($caregivers as $caregiver){
        try{
            Mail::to($caregiver->email)->send(new LicenseExpiring($caregiver));
            $this->info('Emailed ' . $caregiver->name); //logging each successfull caregiver to console
        }catch(\Exception $e){
            $this->info('Email to: ' . $caregiver->name . ' was not sent successfully'); //on error log to console
        }
    }
})->describe('Notify nurses with licenses expiring soon');
