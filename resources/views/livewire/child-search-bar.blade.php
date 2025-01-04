<div class="d-flex align-items-center" id="child-search-bar">
    <!-- Search Input -->
    <input wire:model="search" type="search" class="form-control" placeholder="Search for a child" aria-label="Search">

    <!-- Results Display -->
    @if (!empty($results))
        <ul wire:ignore style="color: black; list-style-type: none; padding: 0;">
            @foreach ($results as $result)
                <div class="result-item {{ $loop->index % 2 == 0 ? 'light-gray' : 'white' }} py-2 px-3" style="border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                    <section class="row">
                        <div>
                            <li style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div style="flex: 1;">
                                    <input style="display:none;;" ></input>
                                    <strong>Child Name:</strong> 
                                    {{ json_decode($result->fullname)->first_name ?? 'N/A' }} 
                                    {{ json_decode($result->fullname)->middle_name ?? '' }} 
                                    {{ json_decode($result->fullname)->last_name ?? 'N/A' }} 
                                    <br>
                                    <strong>Date of Birth:</strong> {{ $result->dob }}
                                    <br>
                                    <strong>Parent Name:</strong> 
                                    {{ json_decode($result->parent_fullname)->first_name ?? 'N/A' }} 
                                    {{ json_decode($result->parent_fullname)->middle_name ?? 'N/A' }} 
                                    {{ json_decode($result->parent_fullname)->last_name ?? 'N/A' }}
                                    <br>
                                    <strong>Parent Email:</strong> {{ $result->email }}
                                    <br>
                                    <strong>Parent Phone:</strong> {{ $result->telephone ?? 'Not available' }}
                                    <br>
                                </div>
                                <div style="margin-left: 20px;">
                                    <!-- Checkboxes for selection -->
                                    <label class="checkbox-container">
                                        <input type="checkbox" wire:model="selectedItems" value="{{$result->id}}" id="child_id" />
                                        
                                        <span class="checkmark"></span> Select
                                    </label>
                                </div>
                            </li>
                        </div>
                    </section>
                </div>
            @endforeach
        </ul>
    @else
        <p>No results found.</p>
    @endif
</div>
