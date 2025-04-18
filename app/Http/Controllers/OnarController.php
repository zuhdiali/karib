<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Onar;
use App\Models\NominasiOnar;
use App\Models\Outsourcing;
use App\Models\PenilaianOnar;
use App\Models\Pegawai;

class OnarController extends Controller
{
    public function index()
    {
        $onars = Onar::orderBy('created_at', 'asc')->get();
        $totalOnar = count($onars);
        return view('onar.index', ['onars' => $onars, 'totalOnar' => $totalOnar]);
    }

    public function create()
    {
        $outsourcings = Outsourcing::where('flag', null)->get();
        return view('onar.create', compact('outsourcings'));
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

        $cekOnar = Onar::where('tahun', $request->tahun)
            ->where('triwulan', $request->triwulan)
            ->first();

        if ($cekOnar) {
            return redirect()->route('onar.create')->with('error', 'ONAR untuk tahun ' . $request->tahun . ' triwulan ' . $request->triwulan . ' sudah ada.');
        }

        $onar = new Onar();
        $onar->nama = $request->nama;
        $onar->tahun = $request->tahun;
        $onar->triwulan = $request->triwulan;
        $onar->tgl_penilaian = $request->tgl_penilaian;
        if ($request->hasFile('file_banner')) {
            $file = $request->file('file_banner');
            $filename = 'Onar-' . $request->tahun . '-' . $request->triwulan . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $onar->file_banner = 'uploads/' . $filename;
        }
        $onar->save();

        if (!$onar->wasRecentlyCreated) {
            return redirect()->route('onar.create')->with('error', 'Gagal.');
        }

        if ($request->nominasiOnar != null) {
            $onar->nominasiOnar()->attach($request->nominasiOnar);
        }

        return redirect()->route('onar.index')->with('success', 'Onar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $onar = Onar::find($id);
        $outsourcings = Outsourcing::where('flag', null)->get();
        $nominasiOnars = NominasiOnar::where('id_onar', $id)->pluck('id_outsourcing')->toArray();
        return view('onar.edit', compact('onar', 'outsourcings', 'nominasiOnars'));
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

        $onar = Onar::find($id);
        $onar->nama = $request->nama;
        $onar->tahun = $request->tahun;
        $onar->triwulan = $request->triwulan;
        $onar->tgl_penilaian = $request->tgl_penilaian;
        if ($request->hasFile('file_banner')) {
            $file = $request->file('file_banner');
            $filename = 'Onar-' . $request->tahun . '-' . $request->triwulan . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $onar->file_banner = 'uploads/' . $filename;
        }
        $onar->save();
        // if (!$onar->wasChanged()) {
        //     return redirect()->route('onar.edit', $id)->with('error', 'Gagal.');
        // }
        if ($request->nominasiOnar != null) {
            $onar->nominasiOnar()->sync($request->nominasiOnar);
        }

        // if ($onar->wasChanged('file_banner')) {
        //     $oldFile = public_path($onar->getOriginal('file_banner'));
        //     if (file_exists($oldFile)) {
        //         unlink($oldFile);
        //     }
        // }

        return redirect()->route('onar.index')->with('success', 'Onar berhasil diubah.');
    }

    public function show($id)
    {
        $onar = Onar::find($id);
        $data = DB::table('onar')
            ->join('nominasi_onar', 'nominasi_onar.id_onar', '=', 'onar.id')
            ->join('penilaian_onar', 'penilaian_onar.id_nominasi', '=', 'nominasi_onar.id')
            ->join('outsourcing', 'nominasi_onar.id_outsourcing', '=', 'outsourcing.id')
            ->where('onar.id', $id) // <-- Di sinilah tempat WHERE-nya
            ->groupBy('onar.id', 'nominasi_onar.id', 'outsourcing.nama')
            ->select(
                'onar.id as onar_id',
                'nominasi_onar.id as nominasi_id',
                'outsourcing.nama',
                DB::raw('SUM(
                    penilaian_onar.tanggung_jawab +
                    penilaian_onar.disiplin +
                    penilaian_onar.loyal +
                    penilaian_onar.ramah +
                    penilaian_onar.melayani +
                    penilaian_onar.cekatan 
                ) as total_nilai')
            )
            ->get();

        $nominasiOnars = NominasiOnar::where('id_onar', $id)->get();

        $progress  = DB::table('penilaian_onar')
            ->join('nominasi_onar', 'penilaian_onar.id_nominasi', '=', 'nominasi_onar.id')
            ->where('nominasi_onar.id_onar', 11)
            ->select(
                'nominasi_onar.id_onar',
                'penilaian_onar.id_nominasi',
                DB::raw('COUNT(penilaian_onar.id_penilai) as jumlah_penilai')
            )
            ->groupBy('nominasi_onar.id_onar', 'penilaian_onar.id_nominasi')
            ->get();

        $arrayYangSudahMenilai = PenilaianOnar::whereHas('nominasiOnar', function ($query) use ($id) {
            $query->where('id_onar', $id);
        })->pluck('id_penilai')->toArray();

        $penilaianOnars = PenilaianOnar::whereHas('nominasiOnar', function ($query) use ($id) {
            $query->where('id_onar', $id);
        })->get();

        $pegawais = Pegawai::where('flag', null)->get();
        return view('onar.show', compact('onar', 'data', 'nominasiOnars', 'progress', 'pegawais', 'arrayYangSudahMenilai', 'penilaianOnars'));
    }

    public function destroy($id)
    {
        $onar = Onar::find($id);
        $onar->delete();
        return redirect()->route('onar.index')->with('success', 'Onar berhasil dihapus.');
    }

    public function indexPenilaian()
    {
        if (Auth::user()->role != 'Admin') {
            return redirect()->route('onar.index')->with('error', 'Menu penilaian ONAR hanya bisa diakses Admin.');
        }
        $penilaianOnars = PenilaianOnar::orderBy('created_at', 'asc')->get();
        $totalPenilaianOnar = count($penilaianOnars);
        return view('onar.penilaian.index', ['penilaianOnars' => $penilaianOnars, 'totalPenilaianOnar' => $totalPenilaianOnar]);
    }

    public function createPenilaian($id)
    {
        $onar = Onar::find($id);
        if (!$onar) {
            return redirect()->route('onar.index')->with('error', 'Data ONAR tidak ditemukan.');
        }
        if ($onar->tgl_penilaian < now()) {
            return redirect()->route('onar.index')->with('error', 'Penilaian ONAR hanya bisa dilakukan pada tanggal ' . \Carbon\Carbon::parse($onar->tgl_penilaian)->locale('id')->translatedFormat('d F Y') . '.');
        }
        $nominasiOnars = NominasiOnar::where('id_onar', $id)->get();
        $pegawais = Pegawai::where('flag', null)->get();
        return view('onar.penilaian.create', compact('onar', 'nominasiOnars', 'pegawais'));
    }

    public function storePenilaian(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'id_penilai' => 'required|exists:pegawais,id',
            'tanggung_jawab' => 'required',
            'disiplin' => 'required',
            'loyal' => 'required',
            'ramah' => 'required',
            'melayani' => 'required',
            'cekatan' => 'required',
        ]);

        $onar = Onar::find($id);

        $cekPenilaian = PenilaianOnar::whereHas('nominasiOnar', function ($query) use ($id) {
            $query->where('id_onar', $id);
        })->where('id_penilai', $request->id_penilai)->first();

        if ($cekPenilaian) {
            return redirect()->route('penilaian-onar.create', ['id' => $id])->with('error', $cekPenilaian->penilai->nama . ' sudah melakukan penilaian ' . $onar->nama . '.');
        }

        foreach ($request->tanggung_jawab as $key => $value) {
            $penilaian = new PenilaianOnar();
            $penilaian->id_penilai = $request->id_penilai;
            $nominasiOnar = NominasiOnar::find($key);
            if ($nominasiOnar) {
                $penilaian->id_nominasi = $key;
                $penilaian->tanggung_jawab = $value;
                $penilaian->disiplin = $request->disiplin[$key];
                $penilaian->loyal = $request->loyal[$key];
                $penilaian->ramah = $request->ramah[$key];
                $penilaian->melayani = $request->melayani[$key];
                $penilaian->cekatan = $request->cekatan[$key];
            }
            $penilaian->save();
        }

        return redirect()->route('onar.index')->with('success', 'Penilaian berhasil disimpan.');
    }
}
