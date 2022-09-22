<?php

namespace App\Http\Controllers;

use App\Models\Nis;
use App\Models\Kelas;
use App\Models\Kelasmi;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\Pesertakelas;
use App\Models\Statuspengamal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::query()
            ->leftjoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftjoin('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->leftjoin('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->leftjoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftjoin('pesertakelas', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->orderBy('nis')
            ->orderBy('nama_siswa')
            // ->orderBy('nama_siswa')

            ->select(
                [
                    'nis.nis',
                    'nis.tanggal_masuk',
                    'siswa.id',
                    'siswa.nama_siswa',
                    'siswa.jenis_kelamin',
                    'siswa.tempat_lahir',
                    'siswa.tanggal_lahir',
                    'kelasmi.nama_kelas',
                    'asrama.nama_asrama'
                ]
            );
            // ->latest()->orderBy('nama_siswa');
        if (request('cari')) {
            $data->where('nama_siswa', 'like', '%' . request('cari') . '%')
                ->orWhere('Kota_asal', 'like', '%' . request('cari') . '%')
            ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            ->orWhere('nis', 'like', '%' . request('cari') . '%')
            ->orWhere('tanggal_masuk', 'like', '%' . request('cari') . '%')
            ->orderBy('nis', 'asc');
        }
        return view('siswa/siswa', ['dataSiswa' => $data->paginate(20)]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siswa/addsiswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|min:5|max:25',

        ], [
            'nama_siswa.min' => 'tidak boleh kurang dari 2 karakter',
            'nama_siswa.max' => 'tidak boleh lebih dari 3 karakter'
        ]);
        $siswa = new Siswa();
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->agama = $request->agama;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tanggal_lahir = $request->tanggal_lahir;
        $siswa->kota_asal = $request->kota_asal;
        $siswa->save();

        $status_pengamal = new Statuspengamal();
        $status_pengamal->siswa_id = $siswa->id;
        $status_pengamal->status_pengamal = $request->status_pengamal;
        $status_pengamal->save();
        return redirect('siswa')->with('success', 'data berhasil ditambahkan');
    }
    public function storeNis(Request $request)
    {
        
        $nis = new nis();
        $nis->siswa_id = $request->siswa_id;
        $nis->nis = $request->nis;
        $nis->nama_lembaga = $request->nama_lembaga;
        $nis->madrasah_diniyah = $request->madrasah_diniyah;
        $nis->tanggal_masuk = $request->tanggal_masuk;
        $nis->save();
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa, Pesertakelas $pesertakelas)
    {
        $pes = Pesertakelas::query()
            ->join('siswa', 'siswa.id', 'pesertakelas.siswa_id')
            ->select('pesertakelas.siswa_id')
            ->where('siswa_id', $siswa->id)->first();
        return view('siswa/detailSiswa', ['siswa' => $siswa, 'pesertakelas' => $pes]);
    }
    public function biodata(Siswa $siswa)
    {
        $data = Siswa::where('siswa.id', $siswa->id)
            // ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('statuspengamal', 'siswa.id', '=', 'statuspengamal.siswa_id')
            ->first();
        return view('siswa/biodata', ['siswa' => $data]);
    }
    public function nis(Siswa $siswa)
    {
        $nisSiswa = Nis::where('siswa_id', $siswa->id)->get();
        return view('siswa/nisSiswa', ['siswa' => $siswa, 'nis' => $nisSiswa]);
    }
    public function DetailKelas(Siswa $siswa, Kelas $kelas)
    {

        $data = siswa::query()
            ->get();
        $dataKelas = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('kelas', 'kelas.id', '=', 'pesertakelas.kelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            // ->where('Pesertakelas.siswa_id', $siswa->id)
            ->get();
        return view('siswa/detailSiswa', ['detailKelas' => $data, 'siswa' => $siswa, 'dataKelas' => $dataKelas]);
    }
    public function transkip(Pesertakelas $pesertakelas, Siswa $siswa)
    {
        
        $transkip = Nilai::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
        ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->select(
                [
                    'siswa.id',
                    'siswa.nama_siswa',
                    'nilai.nilai_ujian',
                    'nilai.nilai_harian',
                    'kelasmi.nama_kelas',
                    'kelasmi.periode_id',
                    'periode.periode',
                    'periode.id',
                    'semester.ket_semester',
                    'mapel.mapel',
                ]
            )
            ->where('pesertakelas.siswa_id', $siswa->id);
        if (request('cari')) {
            $transkip->where(function ($query) {
                $query->where('periode', 'like', '%' . request('cari') . '%')
                ->orWhere('ket_semester', 'like', '%' . request('cari') . '%');
            });
            // ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            // ->orWhere('nis', 'like', '%' . request('cari') . '%')
            // ->orWhere('tanggal_masuk', 'like', '%' . request('cari') . '%')

        }
        $periode = Kelasmi::query()
        ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
        ->select('periode.id', 'periode.periode')
        ->get();
        $tittle = $siswa->query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select(
                [
                    'nis.nis',
                    'siswa.id',
                    'siswa.nama_siswa'
                ]
            )
            ->where('siswa.id', $siswa->id)
            ->first();
        return view(
            'siswa/transkip',
            [
                'siswa' => $siswa,
                'periode' => $periode,
                'tittle' => $tittle,
                'transkip' => $transkip->get(),
            ]
        );
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa, Statuspengamal $statuspengamal)
    {
        $status_pengamal = Statuspengamal::find($siswa)->first();
        return view(
            'siswa/editsiswa',
            [
                'siswa' => $siswa,
                'statuspengamal' => $status_pengamal
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        Siswa::where('id', $siswa->id)
            ->update([
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'kota_asal' => $request->kota_asal,
            ]);
        Statuspengamal::where('siswa_id', $siswa->id)
            ->update([
                'siswa_id' => $siswa->id,
                'status_pengamal' => $request->status_pengamal,
            ]);
        return redirect('/siswa')->with('update', 'pembaharuan data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $siswa)
    {
        Siswa::destroy($siswa->id);
        return redirect()->back()->with('delete', 'data berhasil dihapus');
    }
    public function destroyNis(Nis $nis)
    {
        // dd($nis);
        Nis::destroy($nis->id);
        return redirect()->back();
    }
}
