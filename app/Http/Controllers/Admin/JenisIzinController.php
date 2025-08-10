<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisIzin;
use Illuminate\Http\Request;

class JenisIzinController extends Controller
{
    public function index()
    {
        $jenisIzin = JenisIzin::all();
        return view('pages.admin.jenis_izin.index', compact('jenisIzin'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'perlu_bukti' => $request->has('perlu_bukti'), // Konversi ke boolean
            'is_dinas' => $request->has('is_dinas')
        ]);

        $request->validate([
            'kode' => 'required|unique:jenis_izin,kode|max:3',
            'nama' => 'required'
        ]);

        JenisIzin::create($request->all());
        return redirect()->route('jenis-izin.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $jenisIzin = JenisIzin::findOrFail($id);

        $request->merge([
            'perlu_bukti' => $request->has('perlu_bukti'), // Konversi ke boolean
            'is_dinas' => $request->has('is_dinas')
        ]);

        $request->validate([
            'kode' => 'required|unique:jenis_izin,kode,' . $id . '|max:3',
            'nama' => 'required'
        ]);

        $jenisIzin->update($request->all());

        return redirect()->route('jenis-izin.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $jenisIzin = JenisIzin::findOrFail($id);
        $jenisIzin->delete();
        return back()->with('success', 'Data dihapus!');
    }
}
