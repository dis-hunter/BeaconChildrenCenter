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
                wire:focus="$set('isFocused',true)"
                wire:blur="$set('isFocused',false)"
                style="width: 300px;" 
            />
            </div>
            <div wire:loading.block class="loader"></div>
            <style>
                .loader {
                    height: 5px;
                    width: inherit;
                    --c:no-repeat linear-gradient(#6100ee 0 0);
                    background: var(--c),var(--c),#d7b8fc;
                    background-size: 60% 100%;
                    animation: l16 3s infinite;
                    border-radius: 5px;
                    }
                @keyframes l16 {
                    0%   {background-position:-150% 0,-150% 0}
                    66%  {background-position: 250% 0,-150% 0}
                    100% {background-position: 250% 0, 250% 0}
                    }
            </style>
            
        
    
        <!-- Results Dropdown -->
        @if($isFocused && (!empty($query) || !empty($history)))
        <div class="dropdown-menu show w-100 position-absolute mt-1" style="z-index: 1050; max-height: 300px; overflow-y: auto;">
            <button
                type="button"
                class="btn-close position-absolute top-0 end-0 m-2"
                aria-label="Close"
                wire:click="$set('query', '')"
                style="z-index: 1051;"
            ></button>
        
            {{-- Search History --}}
            @if(empty($query) && !empty($history))
            <h6 class="dropdown-header">Search History</h6>
            @foreach($history as $item)
                <div class="dropdown-item">
                    <a href="{{ route(strtolower($item['model']) . '.search', ['id' => $item['id']]) }}" class="text-decoration-none">
                        {{ $item['name'] }}
                    </a>
                </div>
            @endforeach
            <div class="dropdown-item">
                <button class="btn btn-link text-danger p-0" wire:click="clearHistory">Clear</button>
            </div>
            @endif

            @forelse($results as $model => $records)
                <h6 class="dropdown-header">{{ $model }}</h6>
                @if(empty($records))
                    <div class="dropdown-item text-muted">No {{ strtolower($model) }} found.</div>
                @else
                    @foreach($records as $record)
                        @php
                            $route = strtolower($model) . '.search';
                        @endphp
                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                            <a href="{{ route($route, ['id' => $record->id]) }}" class="text-decoration-none">
                                {{ (($record->fullname?->first_name ?? '').' '.($record->fullname?->middle_name ?? '').' '.($record->fullname?->last_name ?? '')) ?? 'N/A' }}
                            </a>
                            @if (strtolower($model) === 'patients')
                                <a href="{{route('search.visit',['id'=>$record->id])}}"><button class="btn btn-dark btn-sm">Visit</button></a>
                            @endif
                        </div>
                    @endforeach
                @endif
            @empty
                <div class="dropdown-item text-muted">No results found.</div>
            @endforelse
        </div>
        
        @endif
    </div>
    
</div>
