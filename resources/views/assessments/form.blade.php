@extends('layouts.app')

@section('title','Melakukan Penilaian')
@section('page_title','Melakukan Penilaian')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Step 1</span>
                <h3>Pilih periode, karyawan, dan mulai penilaian</h3>
            </div>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label fw-semibold">Periode</label><select class="form-select"><option>Triwulan II 2026</option></select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Karyawan</label><select class="form-select"><option>Dewi Anggraini</option></select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Role</label><select class="form-select"><option>Rekan Sejawat</option></select></div>
            </div>
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Step 2</span>
                <h3>Skor per indikator</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr><th>Indikator</th><th>Skor</th></tr>
                </thead>
                <tbody>
                    <tr><td>Menjaga integritas dan amanah</td><td>5</td></tr>
                    <tr><td>Terus belajar dan mengembangkan kapabilitas</td><td>4</td></tr>
                    <tr><td>Aktif bekerja sama lintas tim</td><td>5</td></tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
