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
                    <span>{{ $summary['title'] }}</span>
                    <strong>{{ $summary['value'] }}</strong>
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
        <form class="row g-3 px-4 pb-4" method="GET" action="{{ route('rekap') }}">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Periode</label>
                <select class="form-select" name="period">
                    <option value="">Semua Periode</option>
                    @foreach($periods as $period)
                        <option value="{{ $period['value'] }}" @selected(($filters['period'] ?? '') === (string) $period['value'])>{{ $period['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Departemen</label>
                <select class="form-select" name="department">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $department)
                        <option value="{{ $department }}" @selected(($filters['department'] ?? '') === $department)>{{ $department }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button class="btn btn-apes" type="submit">Terapkan Filter</button>
                <a href="{{ route('rekap') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
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
                    @forelse($rows as $row)
                        <tr>
                            <td class="fw-semibold">{{ $row['name'] }}</td>
                            <td>{{ $row['department'] }}</td>
                            <td>{{ $row['atasan'] }}</td>
                            <td>{{ $row['rekan'] }}</td>
                            <td>{{ $row['bawahan'] }}</td>
                            <td>{{ $row['self'] }}</td>
                            <td class="fw-semibold">{{ $row['final'] }}</td>
                            <td>@include('components.grade-badge', ['grade' => $row['grade'], 'label' => $row['grade']])</td>
                            <td>@include('components.table-actions', ['view' => route('rekap.show', $row['id']), 'edit' => route('rekap.edit', $row['id']), 'print' => $row['print_url']])</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-secondary py-4">Belum ada data rekap untuk filter yang dipilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-note">
            <span>Menampilkan {{ $resultCount }} data rekap.</span>
        </div>
    </section>
</div>
@endsection
