@extends('layouts.app')

@section('title','Edit Biodata')
@section('page_title','Edit Biodata')

@section('content')
<div class="dashboard-grid">
    <section class="hero-panel card hero-panel-personal">
        <div class="hero-panel-copy">
            <span class="section-pill">Profile</span>
            <h2>{{ $employee->nama_lengkap ?? 'Dewi Anggraini' }}</h2>
            <p>{{ $employee->departemen ?? 'Finance' }} - {{ $employee->jabatan ?? 'Senior Analyst' }}</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip summary-chip-tight">
                <strong>{{ $employee->nip ?? 'EMP-2026-0042' }}</strong>
                <span>NIP</span>
            </div>
            <div class="summary-chip summary-chip-tight">
                <strong>{{ $employee->no_hp ?? '0812-3456-7890' }}</strong>
                <span>No. HP</span>
            </div>
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">{{ $isProfileEdit ? 'Edit Biodata' : 'Employee Form' }}</span>
                <h3>{{ $isProfileEdit ? 'Perbarui data profil' : 'Edit data karyawan' }}</h3>
            </div>
        </div>
        <div class="p-4">
            @if(session('status'))
                <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('status') }}</div>
            @endif
            @include('employees._form', [
                'employee' => $employee,
                'formAction' => $formAction,
                'formMethod' => $formMethod,
                'submitLabel' => $isProfileEdit ? 'Simpan Perubahan' : 'Simpan Karyawan',
                'cancelRoute' => $backRoute,
                'cancelLabel' => $isProfileEdit ? 'Kembali' : 'Batal',
            ])
        </div>
    </section>
</div>
@endsection
