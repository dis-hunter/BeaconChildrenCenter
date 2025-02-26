<x-filament::page>
    <div class="p-4">
        <h1 class="text-2xl font-bold">Encounter Summary</h1>

        <form wire:submit.prevent="fetchVisits" class="flex gap-4 mb-4">
            <x-filament::input type="date" wire:model="startDate" placeholder="Start Date" required />
            <x-filament::input type="date" wire:model="endDate" placeholder="End Date" required />
            <x-filament::button type="submit">Search</x-filament::button>
        </form>

        @if (!empty($visits))
            <table class="min-w-full bg-white border rounded-md shadow-md">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-2">Visit Date</th>
                        <th class="p-2">Child Name</th>
                        <th class="p-2">Doctor Name</th>
                        <th class="p-2">Visit Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        <tr class="border-b">
                            <td class="p-2">{{ $visit->visit_date }}</td>
                            <td class="p-2">
    @php
        $childName = is_string($visit->child->fullname) 
            ? json_decode($visit->child->fullname, true) 
            : (array) $visit->child->fullname;
    @endphp
    {{ $childName['first_name'] ?? '' }} {{ $childName['middle_name'] ?? '' }} {{ $childName['last_name'] ?? '' }}
</td>

<td class="p-2">
    @php
        $doctorName = is_string($visit->doctor->fullname) 
            ? json_decode($visit->doctor->fullname, true) 
            : (array) $visit->doctor->fullname;
    @endphp
    {{ $doctorName['first_name'] ?? '' }} {{ $doctorName['middle_name'] ?? '' }} {{ $doctorName['last_name'] ?? '' }}
</td>
                            <td class="p-2">{{ $visit->visitType->visit_type}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">No visits found for the selected date range.</p>
        @endif
    </div>
</x-filament::page>
