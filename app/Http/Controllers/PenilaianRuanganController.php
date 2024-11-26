<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\PenilaianRuangan;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Ruangan;

use Carbon\Carbon;

class PenilaianRuanganController extends Controller
{
    public function index()
    {
        $totalPenilaian = 0;
        $penilaians = null;
        $ruanganBelumDinilai = null;
        if (Auth::user()->role == 'Penilai') {
            $totalPenilaian = PenilaianRuangan::where([
                ['tanggal_awal_mingguan', '=', Carbon::now()->startOfWeek()->format('Y-m-d')],
                ['penilai', '=', Auth::user()->id],
            ])->count();
            $penilaians = PenilaianRuangan::where('penilai', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            $ruanganBelumDinilai = ($this->ruanganBelumDinilaiMingguIni(Auth::user()->id));
        } else {
            $penilaians = PenilaianRuangan::orderBy('created_at', 'desc')->get();
            $totalPenilaian = PenilaianRuangan::where('tanggal_awal_mingguan', Carbon::now()->startOfWeek()->format('Y-m-d'))->count();
        }
        foreach ($penilaians as $penilaian) {
            $penilaian->ruangan = Ruangan::find($penilaian->ruangan_id);
            $penilaian->penilai = User::find($penilaian->penilai);
        }

        return view('penilaian.ruangan.index', compact('penilaians', 'totalPenilaian', 'ruanganBelumDinilai'));
    }

    public function create()
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.ruangan.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $ruangans = $this->ruanganBelumDinilaiMingguIni(Auth::user()->id);
        return view('penilaian.ruangan.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.ruangan.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $request->validate([
            'ruangan_yang_dinilai' => 'required',
            'tanggal_penilaian' => 'required|date',
            'kebersihan' => 'required|integer|min:0|max:10',
            'keindahan' => 'required|integer|min:0|max:10',
            'kerapian' => 'required|integer|min:0|max:10',
        ]);

        $penilaian = PenilaianRuangan::create([
            'penilai' => Auth::user()->id,
            'ruangan_id' => (int) $request->ruangan_yang_dinilai,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'kebersihan' => $request->kebersihan,
            'keindahan' => $request->keindahan,
            'kerapian' => $request->kerapian,
            'total_nilai' => $request->kebersihan + $request->keindahan + $request->kerapian,
            'tanggal_awal_mingguan' => Carbon::createFromFormat('Y-m-d', $request->tanggal_penilaian, 'Asia/Kuala_Lumpur')->startOfWeek()->format('Y-m-d')
        ]);

        if (!$penilaian->wasRecentlyCreated) {
            return redirect()->route('penilaian.ruangan.create')
                ->with('error', 'Gagal.');
        }

        return redirect()->route('penilaian.ruangan.index')
            ->with('success', 'Penilaian ruangan berhasil.');
    }

    public function show($id)
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.ruangan.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $penilaian = PenilaianRuangan::find($id);
        return view('penilaian.ruangan.show', compact('penilaian'));
    }

    public function edit($id)
    {
        $penilaian = PenilaianRuangan::find($id);

        if ($penilaian->penilai != Auth::user()->id) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $ruangans = Ruangan::get();
        
        return view('penilaian.ruangan.edit', compact('penilaian', 'ruangans'));
    }

    public function update(Request $request, $id)
    {
        $penilaian = PenilaianRuangan::find($id);

        if ($penilaian->penilai != Auth::user()->id) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'ruangan_yang_dinilai' => 'required|integer',
            'tanggal_penilaian' => 'required|date',
            'kebersihan' => 'required|integer|min:0|max:10',
            'keindahan' => 'required|integer|min:0|max:10',
            'kerapian' => 'required|integer|min:0|max:10',
        ]);
        
        $penilaian->update([
            'penilai' => Auth::user()->id,
            'ruangan_id' => $request->ruangan_yang_dinilai,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'kebersihan' => $request->kebersihan,
            'keindahan' => $request->keindahan,
            'kerapian' => $request->kerapian,
            'total_nilai' => $request->kebersihan + $request->keindahan + $request->kerapian,
            'tanggal_awal_mingguan' => Carbon::createFromFormat('Y-m-d', $request->tanggal_penilaian, 'Asia/Kuala_Lumpur')->startOfWeek()->format('Y-m-d')
        ]);

        return redirect()->route('penilaian.ruangan.index')
            ->with('success', 'Penilaian ruangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penilaian = PenilaianRuangan::find($id);

        if ($penilaian->penilai != Auth::user()->id) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $penilaian->delete();

        return redirect()->route('penilaian.ruangan.index')
            ->with('success', 'Penilaian ruangan berhasil dihapus.');
    }

    private function ruanganBelumDinilaiMingguIni($id_penilai)
    {
        $ruangans = DB::table('ruangans')
            ->select('ruangans.*')
            ->leftJoin('penilaian_ruangans', function ($join) use ($id_penilai) {
                $join->on('ruangans.id', '=', 'penilaian_ruangans.ruangan_id')
                    ->where('penilaian_ruangans.tanggal_awal_mingguan', '=', Carbon::now()->startOfWeek()->format('Y-m-d'))
                    ->where('penilaian_ruangans.penilai', '=', $id_penilai);
            })
            ->whereNull('penilaian_ruangans.id')
            ->get();
        return $ruangans;
    }

    public function ruanganBelumDinilaiMingguTertentu(Request $request)
    {
        $id_penilai = $request->id_penilai;
        $tanggal = $request->tanggal;
        $tanggal_awal_mingguan = Carbon::createFromFormat('Y-m-d', $tanggal, 'Asia/Kuala_Lumpur')->startOfWeek()->format('Y-m-d');
        $ruangans = DB::table('ruangans')
        ->select('ruangans.*')
        ->leftJoin('penilaian_ruangans', function ($join) use ($id_penilai, $tanggal_awal_mingguan) {
            $join->on('ruangans.id', '=', 'penilaian_ruangans.ruangan_id')
                ->where('penilaian_ruangans.tanggal_awal_mingguan', '=', $tanggal_awal_mingguan)
                ->where('penilaian_ruangans.penilai', '=', $id_penilai);
        })
        ->whereNull('penilaian_ruangans.id')
        ->orderBy('ruangans.nama', 'asc')
        ->get();
        return response()->json($ruangans);
    }
}
