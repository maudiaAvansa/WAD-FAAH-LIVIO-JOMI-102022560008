<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PasienController extends Controller
{
    // READ: tampilkan semua pasien
    public function index()
    {
        $pasiens = Pasien::orderBy('id')->get();
        return view('pasien.index', compact('pasiens'));
    }

    // CREATE: tampilkan form tambah
    public function create()
    {
        return view('pasien.create');
    }

    // STORE: simpan pasien baru
    public function store(Request $request)
    {
        $data = $request->validate($this->aturan());
        Pasien::create($data);

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    // SHOW: detail 1 pasien
    public function show(Pasien $pasien)
    {
        return view('pasien.show', compact('pasien'));
    }

    // EDIT: tampilkan form edit
    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    // UPDATE: simpan perubahan
    public function update(Request $request, Pasien $pasien)
    {
        $data = $request->validate($this->aturan($pasien->id));
        $pasien->update($data);

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    // DESTROY: hapus pasien
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }

    // Aturan validasi (dipakai di store & update)
    private function aturan($id = null)
    {
        return [
            'no_rm'            => ['required', 'string', 'max:20', Rule::unique('pasiens', 'no_rm')->ignore($id)],
            'nama'             => 'required|string|max:100',
            'nik'              => 'nullable|digits:16',
            'tgl_lahir'        => 'required|date|before_or_equal:today',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'gol_darah'        => 'required|in:-,A,B,AB,O',
            'no_hp'            => 'required|string|max:20',
            'alamat'           => 'required|string',
            'kota'             => 'required|string|max:50',
            'darurat_nama'     => 'required|string|max:100',
            'darurat_hubungan' => 'nullable|string|max:20',
            'darurat_hp'       => 'required|string|max:20',
        ];
    }
}