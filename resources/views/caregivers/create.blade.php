@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h3>Add a Caregiver to <small class="text-muted">{{ $agency->name }}</small></h3>

            @include('partials.form-feedback')

            <form action="{{ route('caregivers.store', $agency) }}" method="POST" class="mt-4">
                @csrf

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="position">Position:</label>
                    <select name="position" class="form-control">
                        @foreach ($positions as $position)
                            <option {{ old('position') == $position ? 'selected' : '' }} value="{{ $position }}">{{ $position }}</option>
                        @endforeach
                    </select>
                </div>

                <section id="license">
                    <label>License Details:</label>

                    <div class="card border-secondary p-4">
                        <div class="form-group">
                            <label for="license_number">License Number:</label>
                            <input type="text" name="license_number" value="{{ old('license_number') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="license_expiration">License Expiry:</label>
                            <input type="date" name="license_expiration" value="{{ old('license_expiration') }}" class="form-control">
                        </div>
                    </div>
                </section>

                <div class="form-group mt-5">
                    <a class="btn btn-outline-secondary mr-2" href="{{ route('agencies.show', $agency) }}" role="button">Back</a>
                    <input type="submit" value="Add" class="btn btn-primary">
                </div>
            </form>

        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    /* Add two event listners one on load and the second for dropdown value change */
    window.addEventListener('load', function(){
        document.getElementsByName('position')[0].addEventListener('change', toggleLicenseDetails);
        toggleLicenseDetails();
    });

    /* Toggle between the positionDetails section display if its skilled nurse */
    function toggleLicenseDetails(){
        var position = document.getElementsByName('position')[0];
        var positionDetails = document.getElementById('license');
        if(position.value == "Skilled Nurse"){
            if(positionDetails.style.display == "none"){
                positionDetails.style.display = "block";
            }
        }else{
            positionDetails.style.display = "none";
        }
    }
</script>
@endpush
