<?php

namespace App\Livewire;

use App\Models\children;
use App\Models\Parents;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $query = '';
    public array $results = [];
    public array $history = [];
    public bool $isFocused = false;
    private bool $isSearching = false;

    protected $updatesQueryString = ['query'];

    protected $queryString = ['query' => ['except' => '']];

    protected $listeners = ['clearSearchHistory' => 'clearHistory'];

    protected const SEARCHABLE_MODELS = [
        'Guardians' => [
            'model' => Parents::class,
            'weight' => 1
        ],
        'Patients' => [
            'model' => children::class,
            'weight' => 2
        ]
    ];

    protected const CACHE_DURATION = 3600; // seconds-1hour
    protected const MIN_QUERY_LENGTH = 3; // characters
    protected const MAX_RESULTS_PER_MODEL = 5; // self-explan
    protected const MAX_HISTORY_ITEMS = 10; // results
    protected const DEBOUNCE_TIME = 300; // milliseconds

    public function mount()
    {
        $this->history = Cache::get($this->getHistoryCacheKey(), []);
    }

    public function updatedQuery()
    {
        $this->isSearching = true;

        if (mb_strlen(trim($this->query)) < self::MIN_QUERY_LENGTH) {
            $this->results = [];
            $this->isSearching = false;
            return;
        }

        $this->performSearch();
        $this->isSearching = false;
    }

    private function performSearch(): void
    {
        $cacheKey = $this->getSearchCacheKey();

        $this->results = Cache::remember(
            $cacheKey,
            self::CACHE_DURATION,
            fn () => $this->executeSearch()
        );

        if (!empty($this->results)) {
            $this->updateHistory();
        }
    }

    private function executeSearch(): array
    {
        $normalizedQuery = mb_strtolower(trim($this->query));
        $results = [];

        foreach (self::SEARCHABLE_MODELS as $key => $config) {
            $searchResults = $config['model']::search($normalizedQuery)
                ->take(self::MAX_RESULTS_PER_MODEL)
                ->get()
                ->map(function ($record) use ($key) {
                    return [
                        'id' => $record->id,
                        'name' => $this->formatName($record),
                        'model' => $key,
                        'type' => strtolower($key)
                    ];
                });

            if ($searchResults->isNotEmpty()) {
                $results[$key] = $searchResults->toArray();
            }
        }
        return $results;
    }

    private function getSearchCacheKey(): string
    {
        return sprintf(
            'search_results_%s_%s',
            md5($this->query),
            $this->getUserIdentifier()
        );
    }

    private function getHistoryCacheKey(): string
    {
        return sprintf(
            'search_history_%s',
            $this->getUserIdentifier()
        );
    }

    private function getUserIdentifier(): string
    {
        return auth()->id() ?? session()->getId();
    }

    private function formatName($record): string
    {
        if (!$record->fullname) {
            return 'N/A';
        }

        return trim(implode(' ', array_filter([
            $record->fullname->first_name ?? '',
            $record->fullname->middle_name ?? '',
            $record->fullname->last_name ?? ''
        ]))) ?: 'N/A';
    }

    private function updateHistory(): void
    {
        if (empty($this->results)) {
            return;
        }

        $newHistory = collect($this->results)
            ->flatten(1)
            ->take(self::MAX_HISTORY_ITEMS)
            ->toArray();

        $this->history = array_values(array_filter($newHistory));
        
        Cache::put(
            $this->getHistoryCacheKey(),
            $this->history,
            now()->addDays(7)
        );
    }

    public function clearHistory()
    {
        $this->history = [];
        Cache::forget($this->getHistoryCacheKey());
    }

    public function render()
    {
        return view('livewire.global-search', ['isSearching' => $this->isSearching]);
    }
}