@extends('layouts.app')

@section('title','Rekap Penilaian')
@section('page_title','Rekap Penilaian')

@section('content')
<div class="dashboard-grid">
    <section class="hero-panel card hero-panel-alt">
        <div class="hero-panel-copy">
            <span class="section-pill">Direktur Recap</span>
            <h2>Filter dan bandingkan hasil penilaian dengan cepat.</h2>
            <p>Gunakan ringkasan ini untuk memeriksa komponen 360, final score, dan grade sebelum membuka detail tiap karyawan.</p>
        </div>
        <div class="hero-panel-summary">
            @foreach($summaryCards as $summary)
                <div class="summary-chip summary-chip-tight">
                    <strong>{{ $summary['value'] }}</strong>
                    <span>{{ $summary['title'] }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Filter</span>
                <h3>Pilih periode dan departemen</h3>
            </div>
        </div>
        <div class="row g-3 px-4 pb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Periode</label>
                <select class="form-select">
                    @foreach($periods as $period)
                        <option>{{ $period['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Departemen</label>
                <select class="form-select">
                    <option>Semua Departemen</option>
                    <option>Finance</option>
                    <option>Operations</option>
                    <option>Commercial</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button class="btn btn-apes">Terapkan Filter</button>
                <button class="btn btn-outline-secondary">Reset</button>
            </div>
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Departemen</th>
                        <th>Atasan</th>
                        <th>Rekan</th>
                        <th>Bawahan</th>
                        <th>Self</th>
                        <th>Final</th>
                        <th>Grade</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr>
                            <td class="fw-semibold">{{ $row['name'] }}</td>
                            <td>{{ $row['department'] }}</td>
                            <td>{{ $row['atasan'] }}</td>
                            <td>{{ $row['rekan'] }}</td>
                            <td>{{ $row['bawahan'] }}</td>
                            <td>{{ $row['self'] }}</td>
                            <td class="fw-semibold">{{ $row['final'] }}</td>
                            <td>@include('components.grade-badge', ['grade' => $row['grade'], 'label' => $row['grade']])</td>
                            <td>@include('components.table-actions', ['view' => route('rekap.show', 1)])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-note">
            <span>Menampilkan 5 dari 112 data</span>
            <div class="fake-pagination">
                <span class="active">1</span>
                <span>2</span>
                <span>3</span>
                <span>4</span>
            </div>
        </div>
    </section>
</div>
@endsection
