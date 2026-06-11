@extends('layouts.app')

@section('title','Kelola Karyawan')
@section('page_title','Kelola Karyawan')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Employee Master</span>
                <h3>Kelola data karyawan</h3>
            </div>
            <a href="{{ route('kelola.karyawan.create') }}" class="btn btn-apes">Tambah Karyawan</a>
        </div>
        <div class="row g-3 px-4 pb-4 pt-3">
            <div class="col-md-5">
                <input class="form-control" type="search" placeholder="Cari nama atau NIP">
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option>Semua Departemen</option>
                    <option>Finance</option>
                    <option>Operations</option>
                    <option>Commercial</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Departemen</th>
                        <th>Posisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-semibold">Dewi Anggraini</td>
                        <td>EMP-2026-0042</td>
                        <td>Finance</td>
                        <td>Senior Analyst</td>
                        <td>@include('components.table-actions', ['view' => '#', 'edit' => route('kelola.karyawan.edit', 1)])</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Sinta Lestari</td>
                        <td>EMP-2026-0043</td>
                        <td>Operations</td>
                        <td>Supervisor</td>
                        <td>@include('components.table-actions', ['view' => '#', 'edit' => route('kelola.karyawan.edit', 1)])</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Rizky Pratama</td>
                        <td>EMP-2026-0044</td>
                        <td>Commercial</td>
                        <td>Officer</td>
                        <td>@include('components.table-actions', ['view' => '#', 'edit' => route('kelola.karyawan.edit', 1)])</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
