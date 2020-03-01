

<span class="badge {{ ($caregiver->license_expiration->diffInDays(date('Y-m-d')) < config('caregivers.license_renewal_reminder_in_days')) ? 'badge-danger' : '' }}">
    {{ $caregiver->license_expiration->diffForHumans() }}
</span>
