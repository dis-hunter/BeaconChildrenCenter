<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <!-- Search Parent Form -->

    <div class="row d-flex justify-content-center search-section">
        <!-- Search Label -->
        <div class="col-lg-1 col-md-2 col-sm-1 p-2 d-flex justify-content-center align-items-center search-label">
            <span class="text-primary">Search</span>
        </div>
    
        <!-- Search Input -->
        <div class="col-lg-5 col-md-5 col-sm-10 p-2">
            <input type="text" wire:model.debounce.300ms="query" class="form-control search-input" placeholder="Enter search term">
            @error('query') 
                <span class="text-danger error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <!-- Search Results -->
    @if($query && count($parents) > 0)
    <div class="mt-4">
        <div class="card card-body search-results">
            <h5 class="results-header">{{count($parents)}} Search Results</h5>
            <div>
            <div>

                <div>
                    <div class="table-result">
                        <span>Name</span>
                        <span>Phone</span>
                        <span>Email</span>
                        <span>National ID</span>
                    </div>
                </div>
            </div>
        </div>
            
                <ul class="results-list">
                    @foreach($parents as $parent)
                        <li class="result-item">
                            <a href="search/{{$parent->id}}" class="result-link">
                                @php
                                    $fullname=json_decode($parent->fullname,true);
                                @endphp
                                <span class="result-title">{{$fullname['first_name'] .' '. $fullname['last_name']}}</span>
                                <span class="result-title">{{ $parent->telephone }}</span>
                                <span class="result-title">{{ $parent->email }}</span>
                                <span class="result-title">{{ $parent->national_id }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @elseif($query)
                <p class="no-results">No results found.</p>
        </div>
    </div>
    @endif
</div>
