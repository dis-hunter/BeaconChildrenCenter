<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="modal fade" id="addParentModal" tabindex="-1" aria-labelledby="addParentModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addParentModalLabel">Add Parent Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body">
                        <!-- Fullname Fields -->
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" id="firstname" wire:model.live="firstname" value="{{ old('firstname') }}" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" id="middlename" wire:model.live="middlename" value="{{ old('middlename') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="lastname" class="form-label">Surname</label>
                                <input type="text" id="lastname" wire:model.live="lastname" value="{{ old('lastname') }}" class="form-control" required>
                            </div>
                        </div>

                        <!-- Date of Birth and Gender -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" id="dob" wire:model.live="dob" value="{{ old('dob') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="gender_id" class="form-label">Gender</label>
                                <select id="gender_id" wire:model.live="gender_id" class="form-select" required>
                                    <option disabled {{old('gender_id') === null ? 'selected' : ''}}>Select...</option>
                                    @foreach ($genders as $item)
                                        <option value="{{$item->id}}" {{old('gender_id') === $item->id ? 'selected' : ''}}>{{$item->gender}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="telephone" class="form-label">Telephone</label>
                                <input type="text" id="telephone" wire:model.live="telephone" value="{{ old('telephone') }}" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" wire:model.live="email" value="{{ old('email') }}" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="national_id" class="form-label">National ID</label>
                                <input type="text" id="national_id" wire:model.live="national_id" value="{{ old('national_id') }}" class="form-control" required>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="employer" class="form-label">Employer</label>
                                <input type="text" id="employer" wire:model.live="employer" value="{{ old('employer') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="insurance" class="form-label">Insurance</label>
                                <input type="text" id="insurance" wire:model.live="insurance" value="{{ old('insurance') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="referer" class="form-label">Referer</label>
                                <input type="text" id="referer" wire:model.live="referer" value="{{ old('referer') }}" class="form-control">
                            </div>
                        </div>

                        <!-- Relationship -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label for="relationship_id" class="form-label">Relationship</label>
                                <select id="relationship_id" wire:model.live="relationship_id" class="form-select">
                                    <option disabled {{old('relationship_id') === null ? 'selected' : ''}}>Select...</option>
                                    @foreach ($relationships as $item)
                                        <option value="{{$item->id}}" {{old('relationship_id') === $item->id ? 'selected' : ''}}>{{$item->relationship}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{-- @if(session()->has('message'))
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <div>

                                        {{session('success')}}

                                    </div>
                                </div>
                                @endif --}}
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
