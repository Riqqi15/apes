@extends('layouts.app')

@section('title','Kelola Karyawan')
@section('page_title','Kelola Karyawan')

@section('content')
<div class="dashboard-grid">
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-0">{{ session('status') }}</div>
    @endif

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Employee Master</span>
                <h3>Kelola data karyawan</h3>
            </div>
            <a href="{{ route('kelola.karyawan.create') }}" class="btn btn-apes">Tambah Karyawan</a>
        </div>
        <form class="row g-3 px-4 pb-4 pt-3" method="GET">
            <div class="col-md-5">
                <input class="form-control" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama, NIP, jabatan, atau departemen">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="department">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $department)
                        <option value="{{ $department }}" @selected(($filters['department'] ?? '') === $department)>{{ $department }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-apes" type="submit">Filter</button>
                <a class="btn btn-outline-secondary" href="{{ route('kelola.karyawan') }}">Reset</a>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td class="fw-semibold">{{ $employee->nama_lengkap }}</td>
                            <td>{{ $employee->nip }}</td>
                            <td>{{ $employee->departemen ?? '-' }}</td>
                            <td>{{ $employee->jabatan ?? '-' }}</td>
                            <td>{{ $employee->no_hp ?? '-' }}</td>
                            <td>
                                @include('components.table-actions', [
                                    'edit' => route('kelola.karyawan.edit', $employee->id_karyawan),
                                    'delete' => route('kelola.karyawan.destroy', $employee->id_karyawan),
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">Belum ada data karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-note">
            <span>Menampilkan {{ $employees->count() }} dari {{ $employees->total() }} data</span>
            {{ $employees->links('pagination::bootstrap-5') }}
        </div>
    </section>
</div>
@endsection
