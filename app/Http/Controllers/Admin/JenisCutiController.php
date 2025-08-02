<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use Illuminate\Http\Request;

class JenisCutiController extends Controller
{
    public function index()
    {
        $cuti = JenisCuti::all();
        return view('pages.admin.jenis_cuti.index', compact('cuti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_cuti' => 'required|string|max:255',
            'max_cuti' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
        JenisCuti::create($request->validate([
            'nama_cuti' => 'required|string|max:255',
            'max_cuti' => 'required|integer|min:1',
            'description' => 'required|string',
        ]));

        return redirect()->back()->with('success', 'Jenis cuti berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_cuti' => 'required|string|max:255',
            'max_cuti' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $cuti = JenisCuti::findOrFail($id);
        $cuti->update([
            'nama_cuti' => $request->nama_cuti,
            'max_cuti' => $request->max_cuti,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Jenis cuti berhasil diperbarui.');
    }

    public function delete($id)
    {
        $cuti = JenisCuti::findOrFail($id);
        $cuti->delete();

        return redirect()->back()->with('success', 'Jenis cuti berhasil dihapus.');
    }
}
