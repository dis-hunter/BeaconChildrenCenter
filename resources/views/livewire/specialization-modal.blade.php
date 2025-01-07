<div>
    <div class="form-floating mb-4">
        <select class="form-select" name="role" id="role" wire:model="role">
            <option disabled {{old('role') === null ? 'selected' : ''}}></option>
            @foreach($roles as $role)
            <option value="{{$role->role}}" {{old('role') === $role->role ? 'selected' : ''}}>{{$role->role}}</option>
            @endforeach
        </select>
        <label for="role">Role</label>
    </div>

@if ($showModal)
            <div class="col-md-6">
                <div class="form-floating mb-4">
                    <select class="form-select" name="specialization" id="specialization" wire:model="specialization">
                        <option disabled {{old('specialization') === null ? 'selected' : ''}}></option>
                        @foreach($specializations as $item)
                        <option value="{{$item->specialization}}" {{old('specialization') === $item->specialization ? 'selected' : ''}}>{{$item->specialization}}</option>
                        @endforeach
                    </select>
                    <label for="specialization">Specialization</label>
                </div>
            </div>
@endif
</div>