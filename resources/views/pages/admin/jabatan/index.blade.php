@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Data Jabatan</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Jabatan</h4>
                    <div>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahJabatan">
                            <i class="bi bi-plus-circle"></i> Tambah Jabatan
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped align-middle">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Jabatan</th>
                                    <th>Kode Jabatan</th>
                                    <th>Status Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jabatan as $jabatan)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $jabatan->nama_jabatan }}</td>
                                        <td class="text-center">{{ $jabatan->kode_jabatan }}</td>
                                        <td class="text-center">
                                            @if ($jabatan->is_active === 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalEditJabatan{{ $jabatan->id }}">Edit</a>
                                            <form action="{{ route('jabatan.delete', $jabatan->id) }}" method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus jabatan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                        <!-- Modal Edit Jabatan -->
                                        <div class="modal fade" id="modalEditJabatan{{ $jabatan->id }}" tabindex="-1"
                                            aria-labelledby="modalEditJabatanLabel{{ $jabatan->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="modalEditJabatanLabel{{ $jabatan->id }}">Edit Jabatan
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="kode_jabatan" class="form-label">Kode
                                                                    Jabatan</label>
                                                                <input type="text" name="kode_jabatan"
                                                                    class="form-control"
                                                                    value="{{ $jabatan->kode_jabatan }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_jabatan" class="form-label">Nama
                                                                    Jabatan</label>
                                                                <input type="text" name="nama_jabatan"
                                                                    class="form-control"
                                                                    value="{{ $jabatan->nama_jabatan }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="is_active" class="form-label">Status
                                                                    Jabatan</label>
                                                                <select name="is_active" class="form-control">
                                                                    <option value="aktif"
                                                                        {{ $jabatan->is_active === 'aktif' ? 'selected' : '' }}>
                                                                        Aktif</option>
                                                                    <option value="nonaktif"
                                                                        {{ $jabatan->is_active === 'nonaktif' ? 'selected' : '' }}>
                                                                        Nonaktif</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data jabatan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Tambah Jabatan -->
    <div class="modal fade" id="modalTambahJabatan" tabindex="-1" aria-labelledby="modalTambahJabatanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('jabatan.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahJabatanLabel">Tambah Jabatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kode_jabatan" class="form-label">Kode Jabatan</label>
                            <input type="text" name="kode_jabatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
