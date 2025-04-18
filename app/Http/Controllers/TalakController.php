<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Talak;
use App\Models\NominasiTalak;
use App\Models\PenilaianTalak;
use App\Models\Pegawai;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TalakController extends Controller
{
    public function index()
    {
        $talaks = Talak::orderBy('created_at', 'asc')->get();
        $totalTalak = count($talaks);
        return view('talak.index', ['talaks' => $talaks, 'totalTalak' => $totalTalak]);
    }

    public function create()
    {
        $pegawais = Pegawai::where('flag', null)->get();
        return view('talak.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request...
        $request->validate([
            'nama' => 'required|max:255',
            'tahun' => 'required|integer',
            'triwulan' => 'required|integer|between:1,4',
            'file_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tgl_penilaian' => 'required|date',
        ]);

        $cekTalak = Talak::where('tahun', $request->tahun)
            ->where('triwulan', $request->triwulan)
            ->first();

        if ($cekTalak) {
            return redirect()->route('talak.create')->with('error', 'TALAK untuk tahun ' . $request->tahun . ' triwulan ' . $request->triwulan . ' sudah ada.');
        }

        $talak = new Talak();
        $talak->nama = $request->nama;
        $talak->tahun = $request->tahun;
        $talak->triwulan = $request->triwulan;
        $talak->tgl_penilaian = $request->tgl_penilaian;
        if ($request->hasFile('file_banner')) {
            $file = $request->file('file_banner');
            $filename = 'Talak-' . $request->tahun . '-' . $request->triwulan . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $talak->file_banner = 'uploads/' . $filename;
        }
        $talak->save();

        if (!$talak->wasRecentlyCreated) {
            return redirect()->route('talak.create')->with('error', 'Gagal.');
        }

        if ($request->nominasiTalak != null) {
            $talak->nominasiTalak()->attach($request->nominasiTalak);
        }

        return redirect()->route('talak.index')->with('success', 'Talak berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $talak = Talak::find($id);
        $pegawais = Pegawai::where('flag', null)->get();
        $nominasiTalaks = NominasiTalak::where('id_talak', $id)->pluck('id_pegawai')->toArray();
        return view('talak.edit', compact('talak', 'pegawais', 'nominasiTalaks'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request...
        $request->validate([
            'nama' => 'required|max:255',
            'tahun' => 'required|integer',
            'triwulan' => 'required|integer|between:1,4',
            'file_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tgl_penilaian' => 'required|date',
        ]);

        $talak = Talak::find($id);
        $talak->nama = $request->nama;
        $talak->tahun = $request->tahun;
        $talak->triwulan = $request->triwulan;
        $talak->tgl_penilaian = $request->tgl_penilaian;
        if ($request->hasFile('file_banner')) {
            $file = $request->file('file_banner');
            $filename = 'Talak-' . $request->tahun . '-' . $request->triwulan . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $talak->file_banner = 'uploads/' . $filename;
        }
        $talak->save();
        // if (!$talak->wasChanged()) {
        //     return redirect()->route('talak.edit', $id)->with('error', 'Gagal.');
        // }
        if ($request->nominasiTalak != null) {
            $talak->nominasiTalak()->sync($request->nominasiTalak);
        }

        // if ($talak->wasChanged('file_banner')) {
        //     $oldFile = public_path($talak->getOriginal('file_banner'));
        //     if (file_exists($oldFile)) {
        //         unlink($oldFile);
        //     }
        // }

        return redirect()->route('talak.index')->with('success', 'Talak berhasil diubah.');
    }

    public function show($id)
    {
        $talak = Talak::find($id);
        $data = DB::table('talak')
            ->join('nominasi_talak', 'nominasi_talak.id_talak', '=', 'talak.id')
            ->join('penilaian_talak', 'penilaian_talak.id_nominasi', '=', 'nominasi_talak.id')
            ->join('pegawais', 'nominasi_talak.id_pegawai', '=', 'pegawais.id')
            ->where('talak.id', $id) // <-- Di sinilah tempat WHERE-nya
            ->groupBy('talak.id', 'nominasi_talak.id', 'pegawais.nama')
            ->select(
                'talak.id as talak_id',
                'nominasi_talak.id as nominasi_id',
                'pegawais.nama',
                DB::raw('SUM(
                    penilaian_talak.orientasi_layanan +
                    penilaian_talak.akuntabel +
                    penilaian_talak.kompeten +
                    penilaian_talak.harmonis +
                    penilaian_talak.loyal +
                    penilaian_talak.adaptif +
                    penilaian_talak.kolaboratif
                ) as total_nilai')
            )
            ->get();

        $nominasiTalaks = NominasiTalak::where('id_talak', $id)->get();

        $progress  = DB::table('penilaian_talak')
            ->join('nominasi_talak', 'penilaian_talak.id_nominasi', '=', 'nominasi_talak.id')
            ->where('nominasi_talak.id_talak', 11)
            ->select(
                'nominasi_talak.id_talak',
                'penilaian_talak.id_nominasi',
                DB::raw('COUNT(penilaian_talak.id_penilai) as jumlah_penilai')
            )
            ->groupBy('nominasi_talak.id_talak', 'penilaian_talak.id_nominasi')
            ->get();

        $arrayYangSudahMenilai = PenilaianTalak::whereHas('nominasiTalak', function ($query) use ($id) {
            $query->where('id_talak', $id);
        })->pluck('id_penilai')->toArray();

        $penilaianTalaks = PenilaianTalak::whereHas('nominasiTalak', function ($query) use ($id) {
            $query->where('id_talak', $id);
        })->get();

        $pegawais = Pegawai::where('flag', null)->get();
        return view('talak.show', compact('talak', 'data', 'nominasiTalaks', 'progress', 'pegawais', 'arrayYangSudahMenilai', 'penilaianTalaks'));
    }

    public function destroy($id)
    {
        $talak = Talak::find($id);
        $talak->delete();
        return redirect()->route('talak.index')->with('success', 'Talak berhasil dihapus.');
    }

    public function indexPenilaian()
    {
        if (Auth::user()->role != 'Admin') {
            return redirect()->route('talak.index')->with('error', 'Menu penilaian TALAK hanya bisa diakses Admin.');
        }
        $penilaianTalaks = PenilaianTalak::orderBy('created_at', 'asc')->get();
        $totalPenilaianTalak = count($penilaianTalaks);
        return view('talak.penilaian.index', ['penilaianTalaks' => $penilaianTalaks, 'totalPenilaianTalak' => $totalPenilaianTalak]);
    }

    public function createPenilaian($id)
    {
        $talak = Talak::find($id);
        if (!$talak) {
            return redirect()->route('talak.index')->with('error', 'Data TALAK tidak ditemukan.');
        }
        if ($talak->tgl_penilaian < now()) {
            return redirect()->route('talak.index')->with('error', 'Penilaian TALAK hanya bisa dilakukan pada tanggal ' . \Carbon\Carbon::parse($talak->tgl_penilaian)->locale('id')->translatedFormat('d F Y') . '.');
        }
        $nominasiTalaks = NominasiTalak::where('id_talak', $id)->get();
        $pegawais = Pegawai::where('flag', null)->get();
        return view('talak.penilaian.create', compact('talak', 'nominasiTalaks', 'pegawais'));
    }

    public function storePenilaian(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'id_penilai' => 'required|exists:pegawais,id',
            'orientasi_layanan' => 'required',
            'akuntabel' => 'required',
            'kompeten' => 'required',
            'harmonis' => 'required',
            'loyal' => 'required',
            'adaptif' => 'required',
            'kolaboratif' => 'required',
        ]);

        $talak = Talak::find($id);

        $cekPenilaian = PenilaianTalak::whereHas('nominasiTalak', function ($query) use ($id) {
            $query->where('id_talak', $id);
        })->where('id_penilai', $request->id_penilai)->first();

        if ($cekPenilaian) {
            return redirect()->route('penilaian-talak.create', ['id' => $id])->with('error', $cekPenilaian->penilai->nama . ' sudah melakukan penilaian ' . $talak->nama . '.');
        }

        foreach ($request->orientasi_layanan as $key => $value) {
            $penilaian = new PenilaianTalak();
            $penilaian->id_penilai = $request->id_penilai;
            $nominasiTalak = NominasiTalak::find($key);
            if ($nominasiTalak) {
                $penilaian->id_nominasi = $key;
                $penilaian->orientasi_layanan = $value;
                $penilaian->akuntabel = $request->akuntabel[$key];
                $penilaian->kompeten = $request->kompeten[$key];
                $penilaian->harmonis = $request->harmonis[$key];
                $penilaian->loyal = $request->loyal[$key];
                $penilaian->adaptif = $request->adaptif[$key];
                $penilaian->kolaboratif = $request->kolaboratif[$key];
            }
            $penilaian->save();
        }

        return redirect()->route('talak.index')->with('success', 'Penilaian berhasil disimpan.');
    }
}
