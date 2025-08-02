<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with(['jabatan', 'user'])->get();
        return view('pages.admin.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        $jabatan = Jabatan::all();
        $users = User::all();
        return view('pages.admin.pegawai.add', compact('jabatan', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jabatan'      => 'required|exists:jabatan,id',
            'id_user'         => 'required|exists:users,id',
            'nip'             => 'required|string|max:50|unique:pegawai,nip',
            'npwp'            => 'required|string|max:50|unique:pegawai,npwp',
            'tempat_lahir'    => 'required|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'agama'           => 'required|string|max:50',
        ]);

        Pegawai::create([
            'id_jabatan'     => $request->id_jabatan,
            'id_user'        => $request->id_user,
            'nip'            => $request->nip,
            'npwp'           => $request->npwp,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'agama'          => $request->agama,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $jabatan = Jabatan::all();
        $users = User::all();

        return view('pages.admin.pegawai.edit', compact('pegawai', 'jabatan', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_jabatan' => 'required',
            'id_user' => 'required',
            'nip' => 'required',
            'npwp' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function delete($id)
    {
        $user = Pegawai::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
