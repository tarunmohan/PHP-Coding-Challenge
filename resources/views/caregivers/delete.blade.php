<form action="{{ route('caregivers.destroy', [$agency, $caregiver]) }}" onsubmit="return confirm('are you sure?')"
              method="POST" style="display:inline;">
    @method('DELETE')
    @csrf
    <button class="text-danger" style="background:none;border:none;">
        <small>[Delete]</small>
    </button>
</form>
