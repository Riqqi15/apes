@extends('layouts.app')

@section('title','Assignment Penilaian')
@section('page_title','Assignment Penilaian')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Assignment</span>
                <h3>Penugasan evaluator</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Assessor</th>
                        <th>Assessee</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Budi Santoso</td>
                        <td>Dewi Anggraini</td>
                        <td>Atasan Langsung</td>
                        <td><span class="status-pill status-pill-warning">Menunggu</span></td>
                    </tr>
                    <tr>
                        <td>Maya Sari</td>
                        <td>Dewi Anggraini</td>
                        <td>Rekan Sejawat</td>
                        <td><span class="status-pill status-pill-success">Selesai</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
