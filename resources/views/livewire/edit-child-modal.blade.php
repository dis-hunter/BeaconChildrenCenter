<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="modal fade" id="editChildModal-{{$child->id}}" tabindex="-1" aria-labelledby="#editChildModalLabel-{{$child->id}}" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="#editChildModalLabel-{{$child->id}}">Edit Child Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="update">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" id="firstname" wire:model.live="firstname" value="{{ old('firstname') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" id="middlename" wire:model.live="middlename" value="{{ old('middlename') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="lastname" class="form-label">Lastname</label>
                                <input type="text" id="lastname" wire:model.live="lastname" value="{{ old('lastname') }}" class="form-control">
                            </div>
                        </div>
                
                        <!-- Date of Birth and Gender -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" id="dob" wire:model.live="dob" value="{{ old('dob') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="gender_id" class="form-label">Gender</label>
                                <select id="gender_id" wire:model.live="gender_id" class="form-select">
                                    <option disabled {{old('gender_id') === null ? 'selected' : ''}}>Select...</option>
                                    @foreach ($genders as $item)
                                    <option value="{{$item->id}}" {{old('gender_id') === $item->id ? 'selected' : ''}}>{{$item->gender}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                
                        <!-- Birth Certificate and Registration Number -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="birth_cert" class="form-label">Birth Certificate</label>
                                <input type="text" id="birth_cert" wire:model.live="birth_cert" value="{{ old('birth_cert') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="registration_number" class="form-label">Registration Number</label>
                                <input type="text" id="registration_number" wire:model.live="registration_number" value="{{ old('registration_number') }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
