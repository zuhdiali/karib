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

        $tanggal_awal_mingguan = Carbon::createFromFormat('Y-m-d', $request->tanggal_penilaian, 'Asia/Kuala_Lumpur')->startOfWeek()->format('Y-m-d');

        if (Penilaian::where([
            ['tanggal_awal_mingguan', '=', $tanggal_awal_mingguan],
            ['penilai', '=', Auth::user()->id],
            ['pegawai_id', '=', $request->pegawai_yang_dinilai]
        ])->exists()) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Pegawai tersebut sudah dinilai pada minggu yang dipilih. Silakan ulangi penilaian!');
        }
        $penilaian = Penilaian::create([
            'penilai' => Auth::user()->id,
            'pegawai_id' => (int) $request->pegawai_yang_dinilai,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'kebersihan' => $request->kebersihan,
            'keindahan' => $request->keindahan,
            'kerapian' => $request->kerapian,
            'penampilan' => $request->penampilan,
            'total_nilai' => $request->kebersihan + $request->keindahan + $request->kerapian + $request->penampilan,
            'tanggal_awal_mingguan' => Carbon::createFromFormat('Y-m-d', $request->tanggal_penilaian, 'Asia/Kuala_Lumpur')->startOfWeek()->format('Y-m-d')
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
        $penilaian = Penilaian::find($id);

        if ($penilaian->penilai != Auth::user()->id) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        return view('penilaian.show', compact('penilaian'));
    }

    public function edit($id)
    {
        $penilaian = Penilaian::find($id);
        if ($penilaian->penilai != Auth::user()->id) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $pegawais = Pegawai::get();
        return view('penilaian.edit', compact('penilaian', 'pegawais'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role != 'Penilai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }
        $request->validate([
            'kebersihan' => 'required|integer|min:0|max:10',
            'keindahan' => 'required|integer|min:0|max:10',
            'kerapian' => 'required|integer|min:0|max:10',
            'penampilan' => 'required|integer|min:0|max:10',
        ]);

        $penilaian = Penilaian::find($id);
        $penilaian->update([
            'penilai' => Auth::user()->id,
            'kebersihan' => $request->kebersihan,
            'keindahan' => $request->keindahan,
            'kerapian' => $request->kerapian,
            'penampilan' => $request->penampilan,
            'total_nilai' => $request->kebersihan + $request->keindahan + $request->kerapian + $request->penampilan
        ]);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil diubah.');
    }

    public function destroy($id)
    {
        $penilaian = Penilaian::find($id);

        if ($penilaian->penilai != Auth::user()->id) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $penilaian->delete();

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus.');
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

    public function pegawaiBelumDinilaiMingguTertentu(Request $request)
    {
        $id_penilai = $request->id_penilai;
        $tanggal = $request->tanggal;
        $tanggal_awal_mingguan = Carbon::createFromFormat('Y-m-d', $tanggal, 'Asia/Kuala_Lumpur')->startOfWeek()->format('Y-m-d');
        $pegawais = DB::table('pegawais')
            ->select('pegawais.*')
            ->leftJoin('penilaians', function ($join) use ($id_penilai, $tanggal_awal_mingguan) {
                $join->on('pegawais.id', '=', 'penilaians.pegawai_id')
                    ->where('penilaians.tanggal_awal_mingguan', '=', $tanggal_awal_mingguan)
                    ->where('penilaians.penilai', '=', $id_penilai);
            })
            ->whereNull('penilaians.id')
            ->orderBy('pegawais.nama', 'asc')
            ->get();

        return response()->json($pegawais);
    }
}
