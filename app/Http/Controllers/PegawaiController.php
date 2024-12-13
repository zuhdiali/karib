<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Ruangan;
use App\Models\Penilaian;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawaiAktif = Pegawai::where('flag', null)->count();
        $pegawais = Pegawai::orderBy('nama', 'asc')->get();
        foreach ($pegawais as $pegawai) {
            $pegawai->ruangan = Ruangan::find($pegawai->ruangan);
        }
        return view('pegawai.index', ['pegawais' => $pegawais, 'pegawaiAktif' => $pegawaiAktif]);
    }

    public function create()
    {
        $ruangans = Ruangan::orderBy('nama', 'asc')->get();
        return view('pegawai.create', ['ruangans' => $ruangans]);
    }

    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'nama' => 'required|max:50',
            'ruangan' => 'required',
        ]);

        $pegawai = new Pegawai;
        $pegawai->nama = $request->nama;
        $pegawai->ruangan = $request->ruangan;
        $pegawai->save();

        if (!$pegawai->wasRecentlyCreated) {
            return redirect()->route('pegawai.create')->with('error', 'Gagal.');
        }

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        $ruangans = Ruangan::orderBy('nama', 'asc')->get();
        return view('pegawai.edit', ['pegawai' => $pegawai, 'ruangans' => $ruangans]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request...
        $request->validate([
            'nama' => 'required|max:50',
            'ruangan' => 'required',
            'flag' => 'required',
        ]);

        $pegawai = Pegawai::find($id);
        $pegawai->nama = $request->nama;
        $pegawai->ruangan = $request->ruangan;
        if ($request->flag == "Aktif") {
            $pegawai->flag = null;
        }
        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diubah.');
    }

    public function destroy($id)
    {
        // $penilaians = Penilaian::where('pegawai_id', $id)->get();
        // $penilaians->each->delete();
        $pegawai = Pegawai::find($id);
        $pegawai->flag = "Dihapus";
        $pegawai->save();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
