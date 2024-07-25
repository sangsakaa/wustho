<div>
    <div class="relative">
        <input type="text" class="form-input" placeholder="Search..." wire:model="search">

        @if (!empty($search))
        <div class="absolute bg-white border border-gray-300 mt-1 w-full z-10">
            @if (!empty($results))
            <ul>
                @foreach ($results as $result)
                <li class="p-2 hover:bg-gray-200">{{ $result->nama_guru }}</li> <!-- Ganti 'name' dengan kolom yang sesuai -->
                @endforeach
            </ul>
            @else
            <div class="p-2">No results found</div>
            @endif
        </div>
        @endif
    </div>

</div>