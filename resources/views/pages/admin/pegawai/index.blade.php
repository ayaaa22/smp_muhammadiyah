@extends('layouts.master')

@section('content')

<style>
    .table th,
    .table td {
        vertical-align: middle;
    }
</style>

<div class="page-heading mb-4">
    <h3>Daftar Pegawai</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="card shadow rounded">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Daftar Pegawai</h4>
                <div>
                    <a href="#" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-upload"></i> Import Excel
                    </a>
                    <a href="{{ route('pegawai.add') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Pegawai
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle">
                        <thead class="table-primary">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>NPWP</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Agama</th>
                                <th>Jabatan</th>
                                <th>Pangkat Golongan</th>
                                <th>Jumlah Cuti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pegawai as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $item->user->name }}</strong><br>
                                    <small class="text-muted">NIP.{{ $item->nip }}</small>
                                </td>
                                <td>{{ $item->npwp }}</td>
                                <td>{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                                <td class="text-center">{{ $item->jenis_kelamin }}</td>
                                <td class="text-center">{{ $item->agama }}</td>
                                <td>{{ $item->jabatan->nama_jabatan ?? '-' }}</td>
                                <td class="text-center">-</td> {{-- Ubah jika punya field golongan --}}
                                <td class="text-center"><span class="badge bg-primary">0/8</span></td> {{-- Sesuaikan dengan logic cuti --}}
                                <td class="text-center">
                                    <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('pegawai.delete', $item->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin hapus?')">
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
                                <td colspan="10" class="text-center">Tidak ada data pegawai.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection