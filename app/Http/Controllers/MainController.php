<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ruangan;
use App\Models\Pegawai;
use App\Models\Penilaian;
use App\Models\PenilaianRuangan;
use App\Http\Controllers\PenilaianController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            ->select(DB::raw('DISTINCT YEAR(tanggal_penilaian) AS "Tahun", WEEK(tanggal_penilaian, 1) AS "Minggu"'))
            ->orderBy('Tahun', 'desc')
            ->orderBy('Minggu', 'desc')
            ->get();

        $apakah_ada_penilaian = Penilaian::where('tanggal_awal_mingguan', $tanggal_awal_mingguan)->count();

        // Progress penilaian 
        $penilais = User::where('role', 'Penilai')->get();
        // if(Auth::check()){
        //     $jumlah_pegawai = PenilaianController::pegawaiBelumDinilaiMingguIni(Auth::user()->id)->count();
        // }
        // else {
        $jumlah_pegawai = Pegawai::where('flag', null)->count();
        // }
        $jumlah_ruangan = Ruangan::count();
        foreach ($penilais as $penilai) {
            $penilai->jumlah_penilaian = Penilaian::where('penilai', $penilai->id)->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)->count();
            $penilai->jumlah_penilaian_ruangan = PenilaianRuangan::where('penilai', $penilai->id)->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)->count();
        }

        // dd($jumlah_pegawai);
        return view('index', compact(
            'filterMingguan',
            'penilais',
            'jumlah_pegawai',
            'jumlah_ruangan',
            'apakah_ada_penilaian'
        ));
    }

    public function rekap()
    {
        if (Auth::user()->role != 'Admin') {
            return redirect()->route('index')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
        $tanggal_awal_mingguan = Carbon::now()->startOfWeek()->format('Y-m-d');
        // Membuat daftar filter untuk penilaian
        $filterMingguan = DB::table('penilaians')
            ->select(DB::raw('DISTINCT YEAR(tanggal_penilaian) AS "Tahun", WEEK(tanggal_penilaian, 1) AS "Minggu"'))
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

        // flag untuk mencari pegawai dengan nilai tertinggi
        $nilai_pegawai_tinggi = 0;
        $nilai_pegawai_tinggi_nama = "";

        // Mengambil data penilaian pegawai
        $penilaians = DB::table('penilaians')
            ->select(
                'pegawai_id',
                DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
                DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
                DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
                DB::raw('round(AVG(penampilan),2) as "rerata_penampilan"'),
                DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
            )
            ->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)
            ->groupBy('pegawai_id')
            ->get();
        foreach ($penilaians as $penilaian) {
            $penilaian->pegawai = Pegawai::find($penilaian->pegawai_id);
            if ($penilaian->rerata_total_nilai >= $nilai_pegawai_tinggi) {
                if ($penilaian->rerata_total_nilai > $nilai_pegawai_tinggi) {
                    $nilai_pegawai_tinggi = $penilaian->rerata_total_nilai;
                    $nilai_pegawai_tinggi_nama = $penilaian->pegawai->nama;
                } else {
                    $nilai_pegawai_tinggi_nama .= "," . $penilaian->pegawai->nama;
                }
            }
        }


        // Mengambil data penilaian ruangan
        $penilaian_ruangans = DB::table('penilaian_ruangans')
            ->select(
                'ruangan_id',
                DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
                DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
                DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
                DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
            )
            ->where('penilai', '<>', 0)
            ->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)
            ->groupBy('ruangan_id')
            ->get();

        // flag untuk mencari ruangan dengan nilai tertinggi
        $nilai_ruang_tinggi_nama = "";
        $nilai_ruang_tinggi = 0;

        foreach ($penilaian_ruangans as $ruangan) {
            $ruangan->ruangan = Ruangan::find($ruangan->ruangan_id);

            // penilaian Kepala BPS
            $ruangan->penilaian_kepala_bps = PenilaianRuangan::where('ruangan_id', $ruangan->ruangan_id)
                ->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)
                ->where('penilai', 0)
                ->first();
            // jika kepala BPS belum menilai pada minggu yang bersangkutan
            if ($ruangan->penilaian_kepala_bps == null) {
                $ruangan->penilaian_kepala_bps = new \stdClass();
                $ruangan->penilaian_kepala_bps->total_nilai = 0;
            }

            // rerata penilaian pegawai dalam satu ruangan
            $ruangan->rerata_pegawai = DB::table('penilaians')
                ->join('pegawais', 'penilaians.pegawai_id', '=', 'pegawais.id')
                ->select('pegawais.ruangan', DB::raw('round(AVG(penilaians.total_nilai),2) as rerata_nilai'))
                ->where('penilaians.tanggal_awal_mingguan', '=', $tanggal_awal_mingguan)
                ->where('pegawais.ruangan', '=', $ruangan->ruangan_id)
                ->groupBy('pegawais.ruangan')
                ->first();

            // jika dalam satu ruangan belum ada pegawai yang dinilai
            if ($ruangan->rerata_pegawai == null) {
                $ruangan->rerata_pegawai = new \stdClass();
                $ruangan->rerata_pegawai->rerata_nilai = 0;
            }


            $ruangan->nilai_akhir = round($ruangan->rerata_total_nilai + $ruangan->penilaian_kepala_bps->total_nilai + $ruangan->rerata_pegawai->rerata_nilai, 2);
            if ($ruangan->nilai_akhir > $nilai_ruang_tinggi) {
                $nilai_ruang_tinggi = $ruangan->nilai_akhir;
                $nilai_ruang_tinggi_nama = $ruangan->ruangan->nama;
            }
        }


        // dd($penilais);
        return view('rekap', compact(
            'penilaians',
            'penilaian_ruangans',
            'filterMingguan',
            'filterBulanan',
            'filterTriwulanan',
            'nilai_ruang_tinggi',
            'nilai_ruang_tinggi_nama',
            'nilai_pegawai_tinggi',
            'nilai_pegawai_tinggi_nama'
        ));
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
        return redirect()->route('index');
    }

    // Fungsi filterMingguan digunakan untuk melihat progress penilaian pada minggu tertentu di halaman progress penilaian
    public function filterMingguan(Request $request)
    {

        $tanggal_awal_mingguan = $request->tanggal_awal_mingguan;

        // Membuat daftar filter untuk penilaian
        $filterMingguan = DB::table('penilaians')
            ->select(DB::raw('DISTINCT YEAR(tanggal_penilaian) AS "Tahun", WEEK(tanggal_penilaian) AS "Minggu"'))
            ->orderBy('Tahun', 'desc')
            ->orderBy('Minggu', 'desc')
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

        // Progress penilaian 
        $penilais = User::where('role', 'Penilai')->get();
        $jumlah_pegawai = Pegawai::count();
        $jumlah_ruangan = Ruangan::count();
        foreach ($penilais as $penilai) {
            $id_penilai = $penilai->id;
            $penilai->jumlah_penilaian = Penilaian::where('penilai', $penilai->id)->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)->count();
            $penilai->jumlah_penilaian_ruangan = PenilaianRuangan::where('penilai', $penilai->id)->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)->count();

            // pegawai yang belum dinilai pada minggu tertentu
            $penilai->pegawai_belum_dinilai =  DB::table('pegawais')
                ->select('pegawais.*')
                ->leftJoin('penilaians', function ($join) use ($id_penilai, $tanggal_awal_mingguan) {
                    $join->on('pegawais.id', '=', 'penilaians.pegawai_id')
                        ->where('penilaians.tanggal_awal_mingguan', '=', $tanggal_awal_mingguan)
                        ->where('penilaians.penilai', '=', $id_penilai);
                })
                ->whereNull('penilaians.id')
                ->orderBy('pegawais.nama', 'asc')
                ->get();
        }

        return response()->json([
            'filterMingguan' => $filterMingguan,
            'penilais' => $penilais,
            'jumlah_pegawai' => $jumlah_pegawai,
            'jumlah_ruangan' => $jumlah_ruangan,
            'tanggal_awal_mingguan' => $tanggal_awal_mingguan
        ]);
    }

    // Fungsi rekapMingguan digunakan untuk melihat rekap penilaian pada minggu tertentu di halaman rekap
    public function rekapMingguan(Request $request)
    {
        // dd($request->all());
        $tanggal_awal_mingguan = $request->tanggal_awal_mingguan;

        // flag untuk mencari nilai tertinggi pegawai
        $nilai_pegawai_tinggi = 0;
        $nilai_pegawai_tinggi_nama = "";

        // Mengambil data penilaian pegawai
        $penilaians = DB::table('penilaians')
            ->select(
                'pegawai_id',
                DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
                DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
                DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
                DB::raw('round(AVG(penampilan),2) as "rerata_penampilan"'),
                DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
            )
            ->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)
            ->groupBy('pegawai_id')
            ->get();
        foreach ($penilaians as $penilaian) {
            $penilaian->pegawai = Pegawai::find($penilaian->pegawai_id);
            if ($penilaian->rerata_total_nilai >= $nilai_pegawai_tinggi && $penilaian->pegawai->flag == null) {
                if ($penilaian->rerata_total_nilai >= $nilai_pegawai_tinggi) {
                    if ($penilaian->rerata_total_nilai > $nilai_pegawai_tinggi) {
                        $nilai_pegawai_tinggi = $penilaian->rerata_total_nilai;
                        $nilai_pegawai_tinggi_nama = $penilaian->pegawai->nama;
                    } else {
                        $nilai_pegawai_tinggi_nama .= " & " . $penilaian->pegawai->nama;
                    }
                }
            }
        }

        // Mengambil data penilaian ruangan
        $penilaian_ruangans = DB::table('penilaian_ruangans')
            ->select(
                'ruangan_id',
                DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
                DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
                DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
                DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
            )
            ->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)
            ->where('penilai', '<>', 0)
            ->groupBy('ruangan_id')
            ->get();

        #flag untuk mencari nilai tertinggi
        $nilai_ruang_tinggi_nama = "";
        $nilai_ruang_tinggi = 0;

        foreach ($penilaian_ruangans as $ruangan) {
            $ruangan->ruangan = Ruangan::find($ruangan->ruangan_id);

            // penilaian Kepala BPS
            $ruangan->penilaian_kepala_bps = PenilaianRuangan::where('ruangan_id', $ruangan->ruangan_id)
                ->where('tanggal_awal_mingguan', $tanggal_awal_mingguan)
                ->where('penilai', 0)
                ->first();
            // jika kepala BPS belum menilai pada minggu yang bersangkutan
            if ($ruangan->penilaian_kepala_bps == null) {
                $ruangan->penilaian_kepala_bps = new \stdClass();
                $ruangan->penilaian_kepala_bps->total_nilai = 0;
            }

            // rerata penilaian pegawai dalam satu ruangan
            $ruangan->rerata_pegawai = DB::table('penilaians')
                ->join('pegawais', 'penilaians.pegawai_id', '=', 'pegawais.id')
                ->select('pegawais.ruangan', DB::raw('round(AVG(penilaians.total_nilai),2) as rerata_nilai'))
                ->where('penilaians.tanggal_awal_mingguan', '=', $tanggal_awal_mingguan)
                ->where('pegawais.ruangan', '=', $ruangan->ruangan_id)
                ->groupBy('pegawais.ruangan')
                ->first();

            // jika dalam satu ruangan belum ada pegawai yang dinilai
            if ($ruangan->rerata_pegawai == null) {
                $ruangan->rerata_pegawai = new \stdClass();
                $ruangan->rerata_pegawai->rerata_nilai = 0;
            }


            $ruangan->nilai_akhir = round($ruangan->rerata_total_nilai + $ruangan->penilaian_kepala_bps->total_nilai + $ruangan->rerata_pegawai->rerata_nilai, 2);
            if ($ruangan->nilai_akhir > $nilai_ruang_tinggi) {
                $nilai_ruang_tinggi = $ruangan->nilai_akhir;
                $nilai_ruang_tinggi_nama = $ruangan->ruangan->nama;
            }
        }

        return response()->json([
            'penilaians' => $penilaians,
            'penilaian_ruangans' => $penilaian_ruangans,
            'tanggal_awal_mingguan' => $tanggal_awal_mingguan,
            'nilai_ruang_tinggi' => $nilai_ruang_tinggi,
            'nilai_ruang_tinggi_nama' => $nilai_ruang_tinggi_nama,
            'nilai_pegawai_tinggi' => $nilai_pegawai_tinggi,
            'nilai_pegawai_tinggi_nama' => $nilai_pegawai_tinggi_nama
        ]);
    }

    // Fungsi rekapBulanan digunakan untuk melihat rekap penilaian pada bulan tertentu di halaman rekap
    public function rekapBulanan(Request $request)
    {
        $tanggal_awal_bulanan = $request->tanggal_awal_bulanan;
        $tanggal_akhir_bulanan = Carbon::parse($tanggal_awal_bulanan)
            ->endOfMonth()->format('Y-m-d');

        // flag untuk mencari nilai tertinggi pegawai
        $nilai_pegawai_tinggi = 0;
        $nilai_pegawai_tinggi_nama = "";

        // Mengambil data penilaian pegawai
        $penilaians = DB::table('penilaians')
            ->select(
                'pegawai_id',
                DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
                DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
                DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
                DB::raw('round(AVG(penampilan),2) as "rerata_penampilan"'),
                DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
            )
            ->where('tanggal_penilaian', '>=', $tanggal_awal_bulanan)
            ->where('tanggal_penilaian', '<=', $tanggal_akhir_bulanan)
            ->groupBy('pegawai_id')
            ->get();
        foreach ($penilaians as $penilaian) {
            $penilaian->pegawai = Pegawai::find($penilaian->pegawai_id);
            if ($penilaian->rerata_total_nilai >= $nilai_pegawai_tinggi && $penilaian->pegawai->flag == null) {
                if ($penilaian->rerata_total_nilai > $nilai_pegawai_tinggi) {
                    $nilai_pegawai_tinggi = $penilaian->rerata_total_nilai;
                    $nilai_pegawai_tinggi_nama = $penilaian->pegawai->nama;
                } else {
                    $nilai_pegawai_tinggi_nama .= " -- " . $penilaian->pegawai->nama;
                }
            }
        }

        // Mengambil data penilaian ruangan
        $penilaian_ruangans = DB::table('penilaian_ruangans')
            ->select(
                'ruangan_id',
                DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
                DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
                DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
                DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
            )
            ->where('tanggal_penilaian', '>=', $tanggal_awal_bulanan)
            ->where('tanggal_penilaian', '<=', $tanggal_akhir_bulanan)
            ->where('penilai', '<>', 0)
            ->groupBy('ruangan_id')
            ->get();

        #flag untuk mencari nilai tertinggi
        $nilai_ruang_tinggi_nama = "";
        $nilai_ruang_tinggi = 0;

        foreach ($penilaian_ruangans as $ruangan) {
            $ruangan->ruangan = Ruangan::find($ruangan->ruangan_id);

            // Lakukan query untuk menghitung rata-rata total_nilai dari kepala BPS
            $penilaian_kepala_bps = DB::table('penilaian_ruangans')
                ->where('penilai', 0)
                ->whereBetween('tanggal_penilaian', [$tanggal_awal_bulanan, $tanggal_akhir_bulanan])
                ->where('ruangan_id', $ruangan->ruangan_id)
                ->select(DB::raw('round(avg(total_nilai), 2) as total_nilai'))
                ->first()->total_nilai;

            // jika kepala BPS belum menilai pada minggu yang bersangkutan
            if ($penilaian_kepala_bps == null) {
                $ruangan->penilaian_kepala_bps = new \stdClass();
                $ruangan->penilaian_kepala_bps->total_nilai = 0;
            } else {
                // Simpan hasil rata-rata ke dalam properti dinamis $ruangan->penilaian_kepala_bps
                $ruangan->penilaian_kepala_bps = (object) ['total_nilai' => $penilaian_kepala_bps];
            }

            // rerata penilaian pegawai dalam satu ruangan
            $ruangan->rerata_pegawai = DB::table('penilaians')
                ->join('pegawais', 'penilaians.pegawai_id', '=', 'pegawais.id')
                ->select('pegawais.ruangan', DB::raw('round(AVG(penilaians.total_nilai),2) as rerata_nilai'))
                ->where('penilaians.tanggal_penilaian', '>=', $tanggal_awal_bulanan)
                ->where('penilaians.tanggal_penilaian', '<=', $tanggal_akhir_bulanan)
                ->where('pegawais.ruangan', '=', $ruangan->ruangan_id)
                ->groupBy('pegawais.ruangan')
                ->first();
            // jika dalam satu ruangan belum ada pegawai yang dinilai
            if ($ruangan->rerata_pegawai == null) {
                $ruangan->rerata_pegawai = new \stdClass();
                $ruangan->rerata_pegawai->rerata_nilai = 0;
            }

            $ruangan->nilai_akhir = round($ruangan->rerata_total_nilai + $ruangan->penilaian_kepala_bps->total_nilai + $ruangan->rerata_pegawai->rerata_nilai, 2);

            if ($ruangan->nilai_akhir > $nilai_ruang_tinggi) {
                $nilai_ruang_tinggi = $ruangan->nilai_akhir;
                $nilai_ruang_tinggi_nama = $ruangan->ruangan->nama;
            }
        }

        return response()->json([
            'penilaians' => $penilaians,
            'penilaian_ruangans' => $penilaian_ruangans,
            'tanggal_awal_bulanan' => $tanggal_awal_bulanan,
            'nilai_ruang_tinggi' => $nilai_ruang_tinggi,
            'nilai_ruang_tinggi_nama' => $nilai_ruang_tinggi_nama,
            'nilai_pegawai_tinggi' => $nilai_pegawai_tinggi,
            'nilai_pegawai_tinggi_nama' => $nilai_pegawai_tinggi_nama
        ]);
    }

    // Fungsi rekapTriwulan digunakan untuk melihat rekap penilaian pada triwulan tertentu di halaman rekap
    public function rekapTriwulan(Request $request)
    {
        $tanggal_awal_triwulanan = $request->tanggal_awal_triwulan;
        $tanggal_akhir_triwulanan = Carbon::parse($tanggal_awal_triwulanan)
            ->addMonths(3)->subDays(1)->format('Y-m-d');

        // flag untuk mengambil nilai tertinggi pegawai
        $nilai_pegawai_tinggi = 0;
        $nilai_pegawai_tinggi_nama = "";

        // Mengambil data penilaian pegawai
        $penilaians = DB::table('penilaians')
            ->select(
                'pegawai_id',
                DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
                DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
                DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
                DB::raw('round(AVG(penampilan),2) as "rerata_penampilan"'),
                DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
            )
            ->where('tanggal_penilaian', '>=', $tanggal_awal_triwulanan)
            ->where('tanggal_penilaian', '<=', $tanggal_akhir_triwulanan)
            ->groupBy('pegawai_id')
            ->get();
        foreach ($penilaians as $penilaian) {
            $penilaian->pegawai = Pegawai::find($penilaian->pegawai_id);
            if ($penilaian->rerata_total_nilai >= $nilai_pegawai_tinggi && $penilaian->pegawai->flag == null) {
                if ($penilaian->rerata_total_nilai > $nilai_pegawai_tinggi) {
                    $nilai_pegawai_tinggi = $penilaian->rerata_total_nilai;
                    $nilai_pegawai_tinggi_nama = $penilaian->pegawai->nama;
                } else {
                    $nilai_pegawai_tinggi_nama .= " -- " . $penilaian->pegawai->nama;
                }
            }
        }

        // Mengambil data penilaian ruangan (sebelumya pake ini)
        // $penilaian_ruangans = DB::table('penilaian_ruangans')
        //     ->select(
        //         'ruangan_id',
        //         DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
        //         DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
        //         DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
        //         DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
        //     )
        //     ->where('tanggal_penilaian', '>=', $tanggal_awal_triwulanan)
        //     ->where('tanggal_penilaian', '<=', $tanggal_akhir_triwulanan)
        //     ->where('penilai', '<>', 0)
        //     ->groupBy('ruangan_id')
        //     ->get();

        // Mengambil data penilaian ruangan (sekarang pake ini karena hanya ingin tahu nama ruangan saja)
        $penilaian_ruangans = DB::table('penilaian_ruangans')
            ->select(
                'ruangan_id',
                DB::raw('round(AVG(kebersihan),2) as "rerata_kebersihan"'),
                DB::raw('round(AVG(kerapian),2) as "rerata_kerapian"'),
                DB::raw('round(AVG(keindahan),2) as "rerata_keindahan"'),
                DB::raw('round(AVG(total_nilai),2) as "rerata_total_nilai"')
            )
            ->where('penilai', '<>', 0)
            ->groupBy('ruangan_id')
            ->get();

        #flag untuk mencari nilai tertinggi
        $nilai_ruang_tinggi_nama = "";
        $nilai_ruang_tinggi = 0;

        foreach ($penilaian_ruangans as $ruangan) {
            $ruangan->ruangan = Ruangan::find($ruangan->ruangan_id);

            // Inisialisasi juara ruangan
            $ruangan->juara_ruangan = null;

            // Lakukan query untuk menghitung rata-rata total_nilai dari kepala BPS
            $penilaian_kepala_bps = DB::table('penilaian_ruangans')
                ->where('penilai', 0)
                ->whereBetween('tanggal_penilaian', [$tanggal_awal_triwulanan, $tanggal_akhir_triwulanan])
                ->where('ruangan_id', $ruangan->ruangan_id)
                ->select(DB::raw('round(avg(total_nilai), 2) as total_nilai'))
                ->first()->total_nilai;

            // jika kepala BPS belum menilai pada minggu yang bersangkutan
            if ($penilaian_kepala_bps == null) {
                $ruangan->penilaian_kepala_bps = new \stdClass();
                $ruangan->penilaian_kepala_bps->total_nilai = 0;
            } else {
                // Simpan hasil rata-rata ke dalam properti dinamis $ruangan->penilaian_kepala_bps
                $ruangan->penilaian_kepala_bps = (object) ['total_nilai' => $penilaian_kepala_bps];
            }

            // rerata penilaian pegawai dalam satu ruangan
            $ruangan->rerata_pegawai = DB::table('penilaians')
                ->join('pegawais', 'penilaians.pegawai_id', '=', 'pegawais.id')
                ->select('pegawais.ruangan', DB::raw('round(AVG(penilaians.total_nilai),2) as rerata_nilai'))
                ->where('penilaians.tanggal_penilaian', '>=', $tanggal_awal_triwulanan)
                ->where('penilaians.tanggal_penilaian', '<=', $tanggal_akhir_triwulanan)
                ->where('pegawais.ruangan', '=', $ruangan->ruangan_id)
                ->groupBy('pegawais.ruangan')
                ->first();

            // jika dalam satu ruangan belum ada pegawai yang dinilai
            if ($ruangan->rerata_pegawai == null) {
                $ruangan->rerata_pegawai = new \stdClass();
                $ruangan->rerata_pegawai->rerata_nilai = 0;
            }

            $ruangan->nilai_akhir = round($ruangan->rerata_total_nilai + $ruangan->penilaian_kepala_bps->total_nilai + $ruangan->rerata_pegawai->rerata_nilai, 2);

            if ($ruangan->nilai_akhir > $nilai_ruang_tinggi) {
                $nilai_ruang_tinggi = $ruangan->nilai_akhir;
                $nilai_ruang_tinggi_nama = $ruangan->ruangan->nama;
            }

            // Menghitung juara tiap ruangan

            foreach ($penilaians as $penilaian) {
                if ($penilaian->pegawai->ruangan == $ruangan->ruangan_id) {
                    if ($ruangan->juara_ruangan == null) {
                        $ruangan->juara_ruangan = (object) [
                            'nama' => $penilaian->pegawai->nama,
                            'nilai' => $penilaian->rerata_total_nilai
                        ];
                    } else {
                        if ($penilaian->rerata_total_nilai > $ruangan->juara_ruangan->nilai) {
                            $ruangan->juara_ruangan = (object) [
                                'nama' => $penilaian->pegawai->nama,
                                'nilai' => $penilaian->rerata_total_nilai
                            ];
                        } elseif ($penilaian->rerata_total_nilai == $ruangan->juara_ruangan->nilai) {
                            $ruangan->juara_ruangan->nama .= " & " . $penilaian->pegawai->nama;
                        }
                    }
                }
            }
        }

        return response()->json([
            'penilaians' => $penilaians,
            'penilaian_ruangans' => $penilaian_ruangans,
            'tanggal_awal_triwulanan' => $tanggal_awal_triwulanan,
            'nilai_ruang_tinggi' => $nilai_ruang_tinggi,
            'nilai_ruang_tinggi_nama' => $nilai_ruang_tinggi_nama,
            'nilai_pegawai_tinggi' => $nilai_pegawai_tinggi,
            'nilai_pegawai_tinggi_nama' => $nilai_pegawai_tinggi_nama
        ]);
    }
}
