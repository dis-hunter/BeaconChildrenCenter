<div>
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
                autocomplete="off"
            />
        </div>

        <div wire:loading wire:target="query" class="loader"></div>

        @if($isFocused && (!empty($query) || !empty($history)))
            <div 
                class="dropdown-menu show w-100 position-absolute mt-1" 
                style="z-index: 1050; max-height: 300px; overflow-y: auto;"
                x-data
                x-on:click.outside="$wire.set('isFocused', false)"
            >
                <button
                    type="button"
                    class="btn-close position-absolute top-0 end-0 m-2"
                    wire:click="$set('query', '')"
                    style="z-index: 1051;"
                ></button>

                @if(empty($query) && !empty($history))
                    <div class="px-2 py-1 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Search History</h6>
                        <button 
                            class="btn btn-link text-danger p-0" 
                            wire:click="clearHistory"
                            wire:loading.attr="disabled"
                        >Clear</button>
                    </div>
                    
                    @foreach($history as $item)
                        <x-search-result-item :item="$item" />
                    @endforeach
                @endif

                @if(!empty($query))
                    @forelse($results as $model => $records)
                        <h6 class="dropdown-header">{{ $model }}</h6>
                        @forelse($records as $record)
                            <x-search-result-item :item="$record" />
                        @empty
                            <div class="dropdown-item text-muted">No {{ strtolower($model) }} found.</div>
                        @endforelse
                    @empty
                        <div class="dropdown-item text-muted">No results found.</div>
                    @endforelse
                @endif
            </div>
        @endif
    </div>

    @push('styles')
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
    @endpush
</div>