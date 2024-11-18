<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Penilaian;
use App\Models\Pegawai;
use App\Models\User;

use Carbon\Carbon;

class PenilaianController extends Controller
{
    public function index()
    {
        $totalPenilaian = 0;
        $penilaians = null;
        $pegawaiBelumDinilai = null;
        if (Auth::user()->role == 'Penilai') {
            // Mengambil riwayat penilaian minggu ini untuk penilai yang sedang login
            $totalPenilaian = Penilaian::where([
                ['tanggal_awal_mingguan', '=', Carbon::now()->startOfWeek()->format('Y-m-d')],
                ['penilai', '=', Auth::user()->id],
            ])->count();
            $penilaians = Penilaian::where('penilai', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            $pegawaiBelumDinilai = ($this->pegawaiBelumDinilaiMingguIni(Auth::user()->id));
        } else {
            // Jika yang login adalah admin, ambil semua riwayat penilaian
            $penilaians = Penilaian::orderBy('created_at', 'desc')->get();
            $totalPenilaian = Penilaian::where('tanggal_awal_mingguan', Carbon::now()->startOfWeek()->format('Y-m-d'))->count();
        }
        foreach ($penilaians as $penilaian) {
            $penilaian->pegawai = Pegawai::find($penilaian->pegawai_id);
            $penilaian->penilai = User::find($penilaian->penilai);
        }

        return view('penilaian.index', compact('penilaians', 'totalPenilaian', 'pegawaiBelumDinilai'));
    }

    public function create()
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $pegawais = $this->pegawaiBelumDinilaiMingguIni(Auth::user()->id);
        return view('penilaian.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $request->validate([
            'pegawai_yang_dinilai' => 'required',
            'tanggal_penilaian' => 'required|date',
            'kebersihan' => 'required|integer|min:0|max:10',
            'keindahan' => 'required|integer|min:0|max:10',
            'kerapian' => 'required|integer|min:0|max:10',
            'penampilan' => 'required|integer|min:0|max:10',
        ]);

        $penilaian = Penilaian::create([
            'penilai' => Auth::user()->id,
            'pegawai_id' => (int) $request->pegawai_yang_dinilai,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'kebersihan' => $request->kebersihan,
            'keindahan' => $request->keindahan,
            'kerapian' => $request->kerapian,
            'penampilan' => $request->penampilan,
            'total_nilai' => $request->kebersihan + $request->keindahan + $request->kerapian + $request->penampilan,
            'tanggal_awal_mingguan' => Carbon::createFromFormat('Y-m-d', $request->tanggal_penilaian, 'Asia/Kuala_Lumpur')->startOfWeek()->format('Y-m-d'),
            'tanggal_awal_triwulanan' =>  Carbon::createFromFormat('Y-m-d', $request->tanggal_penilaian, 'Asia/Kuala_Lumpur')->startOfQuarter()->format('Y-m-d'),
        ]);

        if (!$penilaian->wasRecentlyCreated) {
            return redirect()->route('penilaian.create')
                ->with('error', 'Gagal.');
        }

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil.');
    }

    public function show($id)
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $penilaian = Penilaian::find($id);
        return view('penilaian.show', compact('penilaian'));
    }

    public function edit($id)
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $pegawais = Pegawai::get();
        $penilaian = Penilaian::find($id);
        return view('penilaian.edit', compact('penilaian', 'pegawais'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $request->validate([
            'pegawai_yang_dinilai' => 'required|integer',
            'tanggal_penilaian' => 'required|date',
            'kebersihan' => 'required|integer|min:0|max:10',
            'keindahan' => 'required|integer|min:0|max:10',
            'kerapian' => 'required|integer|min:0|max:10',
            'penampilan' => 'required|integer|min:0|max:10',
        ]);

        $penilaian = Penilaian::find($id);
        $penilaian->update([
            'penilai' => Auth::user()->id,
            'pegawai_id' => $request->pegawai_yang_dinilai,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'kebersihan' => $request->kebersihan,
            'keindahan' => $request->keindahan,
            'kerapian' => $request->kerapian,
            'penampilan' => $request->penampilan,
            'total_nilai' => $request->kebersihan + $request->keindahan + $request->kerapian + $request->penampilan,
            'tanggal_awal_mingguan' => Carbon::createFromFormat('Y-m-d', $request->tanggal_penilaian, 'Asia/Kuala_Lumpur')->startOfWeek()->format('Y-m-d'),
            'tanggal_awal_triwulanan' => Carbon::createFromFormat('Y-m-d', $request->tanggal_penilaian, 'Asia/Kuala_Lumpur')->startOfQuarter()->format('Y-m-d')
        ]);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian updated successfully.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $penilaian = Penilaian::find($id);
        $penilaian->delete();

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian deleted successfully.');
    }

    private function pegawaiBelumDinilaiMingguIni($id_penilai)
    {
        $pegawais = DB::table('pegawais')
            ->select('pegawais.*')
            ->leftJoin('penilaians', function ($join) use ($id_penilai) {
                $join->on('pegawais.id', '=', 'penilaians.pegawai_id')
                    ->where('penilaians.tanggal_awal_mingguan', '=', Carbon::now()->startOfWeek()->format('Y-m-d'))
                    ->where('penilaians.penilai', '=', $id_penilai);
            })
            ->whereNull('penilaians.id')
            ->orderBy('pegawais.nama', 'asc')
            ->get();
        return $pegawais;
    }
}
