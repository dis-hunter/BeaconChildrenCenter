
<div class="dropdown-item d-flex justify-content-between align-items-center">
    <a href="{{ route($item['type'] . '.search', ['id' => $item['id']]) }}" 
       class="text-decoration-none">
        {{ $item['name'] }}
    </a>
    @if ($item['type'] === 'patients')
        <a href="{{ route('search.visit', ['id' => $item['id']]) }}">
            <button class="btn btn-dark btn-sm">Visit</button>
        </a>
    @endif
</div>