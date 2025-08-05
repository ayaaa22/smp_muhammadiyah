@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Edit Data Pegawai</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_jabatan" class="form-label">Jabatan</label>
                            <select name="id_jabatan" class="form-control" required>
                                @foreach($jabatan as $j)
                                    <option value="{{ $j->id }}" {{ $pegawai->id_jabatan == $j->id ? 'selected' : '' }}>{{ $j->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_user" class="form-label">User</label>
                            <select name="id_user" class="form-control" required>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ $pegawai->id_user == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ $pegawai->nip }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="npwp" class="form-label">NPWP</label>
                            <input type="text" name="npwp" class="form-control" value="{{ $pegawai->npwp }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ $pegawai->tempat_lahir }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $pegawai->tanggal_lahir }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="Laki-laki" {{ $pegawai->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $pegawai->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control" value="{{ $pegawai->agama }}" required>
                        </div>
                    </div>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
