<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <!-- Search Parent Form -->
    {{-- <form wire:submit.prevent="searchParent" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <!-- Dropdown for Search Column -->
                <select wire:model="searchColumn" class="form-select">
                    @foreach($searchColumns as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('searchColumn') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <!-- Search Term Input -->
                <input type="text" wire:model="searchTerm" class="form-control" placeholder="Enter search term">
                @error('searchTerm') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div col-md-2>
        <button type="submit" class="btn btn-secondary mt-3">Search</button>
    </div>
    </form>

    <!-- Children List -->
    @if(!empty($children))
        <h4>Children:</h4>
        <ul class="list-group">
            @foreach($children as $child)
                <li class="list-group-item">{{ $child->name }}</li>
            @endforeach
        </ul>
    @elseif($searchTerm)
        <p>No children found for this parent.</p>
    @endif --}}

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 p-2">
    <select wire:model="selectedColumn" class="form-select">
        @foreach($searchColumns as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>
<div class="col-lg-8 col-md-6 col-sm-12 p-2">
    <input type="text" wire:model="query" class="form-control" placeholder="Enter search term">
                @error('query') <span class="text-danger">{{ $message }}</span> @enderror
</div>
    @if (!empty($parents))
    @foreach ($parents as $parent)
        <pre>{{$parent->email}}</pre>
        <pre>{{$parent->telephone}}</pre>
    @endforeach
    @endif
</div>

</div>
