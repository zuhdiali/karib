<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ruangan;
use App\Models\Pegawai;
use App\Models\Penilaian;
use App\Models\PenilaianRuangan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $tanggal_awal_mingguan = Carbon::now()->startOfWeek()->format('Y-m-d');

        // Membuat daftar filter untuk penilaian
        $filterMingguan = DB::table('penilaians')
            ->select(DB::raw('DISTINCT YEAR(tanggal_penilaian) AS "Tahun", WEEK(tanggal_penilaian) AS "Minggu"'))
            ->orderBy('Tahun', 'desc')
            ->orderBy('Minggu', 'desc')
            ->get();
        $filterBulanan = DB::table('penilaians')
            ->select(DB::raw('DISTINCT YEAR(tanggal_penilaian) AS "Tahun", MONTH(tanggal_penilaian) AS "Bulan"'))
            ->orderBy('Tahun', 'desc')
            ->orderBy('Bulan', 'desc')
            ->get();
        $filterTriwulanan = DB::table('penilaians')
            ->select(DB::raw('DISTINCT YEAR(tanggal_penilaian) AS "Tahun", QUARTER(tanggal_penilaian) AS "Triwulan"'))
            ->orderBy('Tahun', 'desc')
            ->orderBy('Triwulan', 'desc')
            ->get();
            

        // Mengambil data penilaian pegawai
        $penilaians = DB::table('penilaians')
        ->select(
            'pegawai_id',
            DB::raw('AVG(kebersihan) as "rerata_kebersihan"'),
            DB::raw('AVG(kerapian) as "rerata_kerapian"'),
            DB::raw('AVG(keindahan) as "rerata_keindahan"'),
            DB::raw('AVG(penampilan) as "rerata_penampilan"'),
            DB::raw('AVG(total_nilai) as "rerata_total_nilai"')
        )
        ->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)
        ->groupBy('pegawai_id')
        ->get();
        foreach ($penilaians as $penilaian) {
            $penilaian->pegawai = Pegawai::find($penilaian->pegawai_id);
        }
        

        // Mengambil data penilaian ruangan
        $penilaian_ruangans = DB::table('penilaian_ruangans')
        ->select(
            'ruangan_id',
            DB::raw('AVG(kebersihan) as "rerata_kebersihan"'),
            DB::raw('AVG(kerapian) as "rerata_kerapian"'),
            DB::raw('AVG(keindahan) as "rerata_keindahan"'),
            DB::raw('AVG(total_nilai) as "rerata_total_nilai"')
        )
        ->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)
        ->groupBy('ruangan_id')
        ->get();
        
        foreach ($penilaian_ruangans as $ruangan) {
            $ruangan->ruangan = Ruangan::find($ruangan->ruangan_id);
        }

        // Progress penilaian 
        $penilais = User::where('role', 'Penilai')->get();
        $jumlah_pegawai = Pegawai::count();
        $jumlah_ruangan = Ruangan::count();
        foreach ($penilais as $penilai) {
            $penilai->jumlah_penilaian = Penilaian::where('penilai', $penilai->id)->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)->count();
            $penilai->jumlah_penilaian_ruangan = PenilaianRuangan::where('penilai', $penilai->id)->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)->count();
        }

        // dd($penilais);
        return view('index', compact('penilaians', 'penilaian_ruangans','filterMingguan', 'filterBulanan', 'filterTriwulanan', 'penilais', 'jumlah_pegawai', 'jumlah_ruangan'));
    }

    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('index');
        }

        return back()->withErrors([
            'username' => 'Username atau kata sandi salah.',
            'password' => 'Username atau kata sandi salah.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
