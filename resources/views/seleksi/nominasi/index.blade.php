<x-app-layout>
    <x-slot name="header">
        @section('title','| NOMINASI : ' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class=" bg-white   px-2 py-2 gap-2">

        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    @foreach ($mapel as $m)
                    <th>{{ $m->mapel }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $s)
                <tr>
                    <td>{{ $s->nama_siswa }}</td>
                    @foreach ($mapel as $m)
                    <td>
                        @if (isset($nilaiPesertaKelasMap[0][$s->nama_siswa][$m->mapel]))
                        {{ $nilaiPesertaKelasMap[0][$s->nama_siswa][$m->mapel]['nilaiHarian'] }}
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>




    </div>
</x-app-layout>