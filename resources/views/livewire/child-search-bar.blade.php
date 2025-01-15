<div class="d-flex align-items-center flex-column" id="child-search-bar">
    <label for="search-bar" style="color: black !important;"> Search </label> 
    <!-- Search Input -->
    <input wire:model="search" type="search" name="search-bar"id="search-bar" class="form-control mb-2" placeholder="Search for a child" aria-label="Search">

    <!-- Results Display -->
    @if (!empty($results))
        <div class="results-container" style="width: 330px !important; max-height:  300px; margin-left:140px !important;overflow-y: auto; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
            <ul wire:ignore style="color: black; list-style-type: none; padding: 0; margin: 0;">
                @foreach ($results as $result)
                    <li class="result-item {{ $loop->index % 2 == 0 ? 'light-gray' : 'white' }} py-2 px-3" style="border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                        <div style="flex: 1;">
                            <strong>Child Name:</strong> 
                            {{ $result->fullname->first_name ?? 'N/A' }} 
                            {{ $result->fullname->middle_name ?? '' }} 
                            {{ $result->fullname->last_name ?? 'N/A' }} 
                            <br>
                            <strong>Date of Birth:</strong> {{ $result->dob }}
                            <br>
                            <strong>Parent Name:</strong> 
                            {{ $result->parent_fullname->first_name ?? 'N/A' }} 
                            {{ $result->parent_fullname->middle_name ?? 'N/A' }} 
                            {{ $result->parent_fullname->last_name ?? 'N/A' }}
                            <br>
                            <strong>Parent Email:</strong> {{ $result->email }}
                            <br>
                            <strong>Parent Phone:</strong> {{ $result->telephone ?? 'Not available' }}
                        </div>
                        <div >
                            <!-- Checkboxes for selection -->
                            <label class="checkbox-container">
                                <input type="checkbox" wire:model="selectedItems" value="{{ $result->id }}" id="child_id_{{ $result->id }}" />
                                <span class="checkmark"></span> Select
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <br>
    @else
        <p style="color:white; margin-top: 10px;">No results found.</p>
    @endif
</div>
