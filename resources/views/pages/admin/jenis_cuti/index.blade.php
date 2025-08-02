@extends('layouts.master')

@section('content')

<style>
    .table th,
    .table td {
        vertical-align: middle;
    }
</style>

<div class="page-heading mb-4">
    <h3>Daftar Jenis Cuti</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="card shadow rounded">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Daftar Jenis Cuti</h4>
                <div>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahCuti">
                        <i class="bi bi-plus-circle"></i> Tambah Jenis Cuti
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle">
                        <thead class="table-primary">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Cuti</th>
                                <th>Maksimal Cuti</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cuti as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_cuti }}</td>
                                <td class="text-center">{{ $item->max_cuti }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <a href="#" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#modalEditCuti{{ $item->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('jenis-cuti.delete', $item->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data jenis cuti.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Tambah Jenis Cuti -->
    <div class="modal fade" id="modalTambahCuti" tabindex="-1" aria-labelledby="modalTambahCutiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('jenis-cuti.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahCutiLabel">Tambah Jenis Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_cuti" class="form-label">Nama Cuti</label>
                            <input type="text" name="nama_cuti" id="nama_cuti" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_cuti" class="form-label">Maksimal Cuti</label>
                            <input type="number" name="max_cuti" id="max_cuti" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($cuti as $item)
    <!-- Modal Edit Jenis Cuti -->
    <div class="modal fade" id="modalEditCuti{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditCutiLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('jenis-cuti.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditCutiLabel{{ $item->id }}">Edit Jenis Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_cuti{{ $item->id }}" class="form-label">Nama Cuti</label>
                            <input type="text" name="nama_cuti" id="nama_cuti{{ $item->id }}" class="form-control" value="{{ $item->nama_cuti }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_cuti{{ $item->id }}" class="form-label">Maksimal Cuti</label>
                            <input type="number" name="max_cuti" id="max_cuti{{ $item->id }}" class="form-control" value="{{ $item->max_cuti }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description{{ $item->id }}" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description{{ $item->id }}" class="form-control" rows="3" required>{{ $item->description }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach


</div>

@endsection