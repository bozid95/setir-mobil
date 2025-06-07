<x-filament::widget>
    <x-filament::card>
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-lg font-bold">Latest Students</h3>
        </div>
        <ul>
            @forelse($students as $student)
                <li class="py-2 border-b last:border-b-0 flex flex-col">
                    <span class="font-semibold">{{ $student->name }}</span>
                    <span class="text-sm text-gray-500">Package: {{ $student->package->name ?? '-' }}</span>
                    <span class="text-xs text-gray-400">Registered:
                        {{ $student->register_date ? \Carbon\Carbon::parse($student->register_date)->format('d M Y') : '-' }}</span>
                </li>
            @empty
                <li class="py-2 text-gray-500">No students found.</li>
            @endforelse
        </ul>
    </x-filament::card>
</x-filament::widget>
