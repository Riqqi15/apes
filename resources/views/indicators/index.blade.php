@extends('layouts.app')

@section('title','Kelola Indikator')
@section('page_title','Kelola Indikator')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Indicator Library</span>
                <h3>Kelola indikator penilaian</h3>
            </div>
            <a href="#" class="btn btn-apes">Tambah Indikator</a>
        </div>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Variable</th>
                        <th>Indikator</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Amanah</td>
                        <td>Menjaga integritas dan amanah dalam bekerja</td>
                        <td><span class="status-pill status-pill-success">Aktif</span></td>
                        <td>@include('components.table-actions', ['edit' => '#', 'delete' => '#'])</td>
                    </tr>
                    <tr>
                        <td>Kompeten</td>
                        <td>Terus belajar dan mengembangkan kapabilitas</td>
                        <td><span class="status-pill status-pill-success">Aktif</span></td>
                        <td>@include('components.table-actions', ['edit' => '#', 'delete' => '#'])</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
