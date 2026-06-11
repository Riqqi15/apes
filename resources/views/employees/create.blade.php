@extends('layouts.app')

@section('title','Tambah Karyawan')
@section('page_title','Tambah Karyawan')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Employee Form</span>
                <h3>Tambah data karyawan</h3>
            </div>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Nama</label><input class="form-control" type="text" placeholder="Nama lengkap"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">NIP</label><input class="form-control" type="text" placeholder="EMP-0000"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Departemen</label><input class="form-control" type="text" placeholder="Finance"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Posisi</label><input class="form-control" type="text" placeholder="Job title"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Email</label><input class="form-control" type="email" placeholder="email@apes.co.id"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Phone</label><input class="form-control" type="text" placeholder="08xx"></div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-apes">Simpan</button>
                <a href="{{ route('kelola.karyawan') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </section>
</div>
@endsection
