<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::all();
        return view('pages.admin.jabatan.index', compact('jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jabatan' => 'required|string|max:255',
            'nama_jabatan' => 'required|string|max:255',
        ]);

        Jabatan::create([
            'kode_jabatan' => $request->kode_jabatan,
            'nama_jabatan' => $request->nama_jabatan,
            'is_active' => 'aktif', // default manual
        ]);

        return redirect()->back()->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jabatan' => 'required',
            'nama_jabatan' => 'required',
            'is_active' => 'required|in:aktif,nonaktif'
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->only('kode_jabatan', 'nama_jabatan', 'is_active'));

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil dihapus.');
    }
}
