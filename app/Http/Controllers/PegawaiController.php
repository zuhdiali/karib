<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Ruangan;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::orderBy('nama', 'asc')->get();
        foreach ($pegawais as $pegawai) {
            $pegawai->ruangan = Ruangan::find($pegawai->ruangan);
        }
        $totalPegawai = count($pegawais);
        return view('pegawai.index', ['pegawais' => $pegawais, 'totalPegawai' => $totalPegawai]);
    }

    public function create()
    {
        return view('pegawai.create');
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
        return view('pegawai.edit', ['pegawai' => $pegawai]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request...
        $request->validate([
            'nama' => 'required|max:50',
            'ruangan' => 'required',
        ]);

        $pegawai = Pegawai::find($id);
        $pegawai->nama = $request->nama;
        $pegawai->ruangan = $request->ruangan;
        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diubah.');
    }

    // public function destroy($id)
    // {
    //     $pegawai = Pegawai::find($id);
    //     $pegawai->delete();
    //     return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    // }
}
