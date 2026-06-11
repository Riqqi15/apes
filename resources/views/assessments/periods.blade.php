@extends('layouts.app')

@section('title','Kelola Penilaian')
@section('page_title','Kelola Penilaian')

@section('content')
<div class="dashboard-grid">
    <section class="content-grid content-grid-wide">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Period Management</span>
                    <h3>Atur periode penilaian</h3>
                </div>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label fw-semibold">Nama Periode</label><input class="form-control" type="text" value="Triwulan II 2026"></div>
                    <div class="col-md-4"><label class="form-label fw-semibold">Mulai</label><input class="form-control" type="date"></div>
                    <div class="col-md-4"><label class="form-label fw-semibold">Selesai</label><input class="form-control" type="date"></div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-apes">Simpan Periode</button>
                    <button class="btn btn-outline-secondary">Reset</button>
                </div>
            </div>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Weight Config</span>
                    <h3>Konfigurasi bobot</h3>
                </div>
            </div>
            <div class="detail-list">
                <div><span>Atasan Langsung</span><strong>40%</strong></div>
                <div><span>Rekan Sejawat</span><strong>20%</strong></div>
                <div><span>Bawahan</span><strong>30%</strong></div>
                <div><span>Self Assessment</span><strong>10%</strong></div>
            </div>
        </div>
    </section>
</div>
@endsection
