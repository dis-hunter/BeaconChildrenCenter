<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="position-relative">
        <div class="input-group" style="border: 1px solid black; border-radius:5px;">
            <span class="input-group-text">
                <i class="fa fa-search"></i>
            </span>
            <input
                type="text"
                class="form-control"
                placeholder="Search..."
                wire:model.debounce.300ms="query"
                style="width: 300px;" 
            />
        </div>
    
        <!-- Results Dropdown -->
        @if(!empty($query))
            <div class="dropdown-menu show w-100 position-absolute mt-1" style="z-index: 1050; max-height: 300px; overflow-y: auto;">
                <button
                type="button"
                class="btn-close position-absolute top-0 end-0 m-2"
                aria-label="Close"
                wire:click="$set('query', '')"
                style="z-index: 1051;"
            ></button>

                @forelse($results as $model => $records)
                    <h6 class="dropdown-header">{{ $model }}</h6>
                    @if($records->isEmpty())
                        <div class="dropdown-item text-muted">No {{ strtolower($model) }} found.</div>
                    @else
                        @foreach($records as $record)
                        @php
                            $route=strtolower($model).'.search';
                        @endphp
                            <a href="{{route($route,['id'=>$record->hash_id])}}" class="dropdown-item">
                                {{ (($record->fullname->first_name ?? '').' '.($record->fullname->middle_name ?? '').' '.($record->fullname->last_name ?? '')) ?? 'N/A' }}
                            </a>
                        @endforeach
                    @endif
                @empty
                    <div class="dropdown-item text-muted">No results found.</div>
                @endforelse
            </div>
        @endif
    </div>
    
    
</div>
