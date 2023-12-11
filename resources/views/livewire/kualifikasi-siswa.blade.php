<div>

    <div>
        <table border="1">
            <thead>
                <tr>
                    <th class="border">No</th>
                    <th class="border">Nama Siswa</th>
                    <th class="border">Periode</th>
                    <th class="border">NIS</th>
                    <th class="border">Nama Kelas</th>
                </tr>
            </thead>
            <tbody>
                @php
                $uniqueCombinations = [];
                @endphp

                @foreach($dataSiswa as $index => $siswa)
                @php
                $combinationKey = $siswa->periode . $siswa->ket_semester;
                @endphp

                @if (!in_array($combinationKey, $uniqueCombinations))
                <tr>
                    <td class="border">{{ $index + 1 }}</td>
                    <td class="border">{{ $siswa->nama_siswa }}</td>
                    <td class="border">{{ $siswa->periode }} {{ $siswa->ket_semester }}</td>
                    <td class="border">{{ $siswa->nis }}</td>
                    <td class="border">{{ $siswa->nama_kelas }}</td>
                </tr>

                @php
                $uniqueCombinations[] = $combinationKey;
                @endphp
                @endif
                @endforeach
            </tbody>
        </table>

    </div>






</div>