@extends('layouts.app')

@section('title','Edit Biodata')
@section('page_title','Edit Biodata')

@section('content')
<div class="dashboard-grid">
    <section class="hero-panel card hero-panel-personal">
        <div class="hero-panel-copy">
            <span class="section-pill">Profile</span>
            <h2>{{ $employee['name'] ?? 'Dewi Anggraini' }}</h2>
            <p>{{ $employee['department'] ?? 'Finance' }} - {{ $employee['position'] ?? 'Senior Analyst' }}</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip summary-chip-tight">
                <strong>{{ $employee['nip'] ?? 'EMP-2026-0042' }}</strong>
                <span>NIP</span>
            </div>
            <div class="summary-chip summary-chip-tight">
                <strong>{{ $employee['email'] ?? 'dewi.anggraini@apes.co.id' }}</strong>
                <span>Email</span>
            </div>
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Edit Biodata</span>
                <h3>Perbarui data profil</h3>
            </div>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Nama</label><input class="form-control" type="text" value="{{ $employee['name'] ?? '' }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">NIP</label><input class="form-control" type="text" value="{{ $employee['nip'] ?? '' }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Departemen</label><input class="form-control" type="text" value="{{ $employee['department'] ?? '' }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Posisi</label><input class="form-control" type="text" value="{{ $employee['position'] ?? '' }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Email</label><input class="form-control" type="email" value="{{ $employee['email'] ?? '' }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Phone</label><input class="form-control" type="text" value="{{ $employee['phone'] ?? '' }}"></div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-apes">Simpan Perubahan</button>
                <a href="{{ route('dashboard.karyawan') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </div>
    </section>
</div>
@endsection
