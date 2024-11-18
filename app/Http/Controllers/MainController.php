<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Penilaian;

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
            
        // dd($filterMingguan, $filterBulanan, $filterTriwulanan);

        // Mengambil data penilaian
        $penilaians = DB::table('penilaians')
        ->select('pegawai_id', DB::raw('AVG(kebersihan) as "rerata_kebersihan", AVG(kerapian) as "rerata_kerapian", AVG(keindahan) as "rerata_keindahan", AVG(penampilan) as "rerata_penampilan", AVG(total_nilai) as "rerata_total_nilai"'))
        ->groupBy('pegawai_id')
        ->get();

        foreach ($penilaians as $penilaian) {
            $penilaian->pegawai = Pegawai::find($penilaian->pegawai_id);
        }
        return view('index', compact('penilaians', 'filterMingguan', 'filterBulanan', 'filterTriwulanan'));
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
            'username' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
