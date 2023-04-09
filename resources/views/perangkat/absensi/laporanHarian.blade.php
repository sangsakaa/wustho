<x-app-layout>
    <x-slot name="header">
        @section('title', ' |Sesi Perangkat ')
        <h2 class="font-semibold text-xl leading-tight">

        </h2>
    </x-slot>
    <div class=" bg-white p-2 sm:p-2  ">
        <div>

            <a href="/sesi-perangkat" class=" bg-blue-600 text-white rounded-md px-2 py-1">kembali Sesi</a>

        </div>
    </div>
    <div class=" mt-2 bg-white p-2 sm:p-2  ">
        <div>
        </div>
        <table class=" w-full">
            <thead>
                <tr class=" border bg-gray-200">
                    <th class=" border border-black">Tanggal</th>
                    <th class=" border border-black">No</th>
                    <th class=" border border-black">Nama Perangkat</th>
                    <th class=" border border-black">Keterangan</th>
                    <th class=" border border-black">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanHarian as $index => $data)
                <tr class="">

                    @if ($index == 0 || $data->tanggal != $laporanHarian[$index-1]->tanggal)
                    <td rowspan="{{ count($laporanHarian->where('tanggal', $data->tanggal)) }}" class=" text-center border border-black">

                        {{ \Carbon\Carbon::parse( $data->tanggal)->isoFormat(' dddd, DD MMMM Y') }}

                    </td>
                    @endif
                    <td class="{{ $data->keterangan == 'alfa' ? 'bg-red-600 text-white' : '' }} px-1 border border-black text-center">{{ $loop->iteration }}</td>
                    <td class="{{ $data->keterangan == 'alfa' ? 'bg-red-600 text-white' : '' }} px-1 border border-black">{{ $data->nama_perangkat }}</td>
                    <td class="{{ $data->keterangan == 'alfa' ? 'bg-red-600 text-white' : '' }} px-1 border border-black text-center capitalize">{{ $data->keterangan }}</td>
                    <td class="{{ $data->keterangan == 'alfa' ? 'bg-red-600 text-white' : '' }} px-1 border border-black text-center">{{ $data->alasan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>





    </div>
</x-app-layout>