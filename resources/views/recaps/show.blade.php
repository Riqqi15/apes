@extends('layouts.app')

@section('title','Detail Rekap')
@section('page_title','Detail Rekap')

@section('content')
<div class="dashboard-grid">
    <section class="hero-panel card hero-panel-print">
        <div class="hero-panel-copy">
            <span class="section-pill">Detail Hasil</span>
            <h2>{{ $employee['name'] }}</h2>
            <p>{{ $employee['department'] }} - {{ $employee['position'] }} - {{ $employee['period'] }}</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip summary-chip-tight">
                <strong>{{ $employee['finalScore'] }}</strong>
                <span>Final Score</span>
            </div>
            <div class="summary-chip summary-chip-tight">
                @include('components.grade-badge', ['grade' => $employee['grade'], 'label' => $employee['grade']])
                <span>Grade</span>
            </div>
        </div>
    </section>

    <section class="content-grid content-grid-wide">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Employee Data</span>
                    <h3>Profil penilaian</h3>
                </div>
            </div>
            <div class="detail-list">
                <div><span>NIP</span><strong>{{ $employee['nip'] }}</strong></div>
                <div><span>Nama</span><strong>{{ $employee['name'] }}</strong></div>
                <div><span>Departemen</span><strong>{{ $employee['department'] }}</strong></div>
                <div><span>Posisi</span><strong>{{ $employee['position'] }}</strong></div>
            </div>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">360 Feedback</span>
                    <h3>Komponen penilaian</h3>
                </div>
            </div>
            <div class="component-bars">
                @foreach($componentScores as $component)
                    <div class="component-row">
                        <div class="component-label">
                            <strong>{{ $component['label'] }}</strong>
                            <span>{{ $component['weight'] }}</span>
                        </div>
                        <div class="component-track"><span style="width: {{ (float) $component['value'] }}%"></span></div>
                        <strong>{{ $component['value'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Variable Score</span>
                <h3>AKHLAK per variable</h3>
            </div>
        </div>
        <div class="variable-grid">
            @foreach($variableScores as $variable)
                <div class="variable-pill">
                    <strong>{{ $variable['name'] }}</strong>
                    <span>{{ $variable['score'] }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head d-flex justify-content-between align-items-center">
            <div>
                <span class="section-pill">Print Ready</span>
                <h3>Siap cetak dan ekspor</h3>
            </div>
            <a href="{{ route('laporan.cetak') }}" class="btn btn-apes">Buka Print View</a>
        </div>
    </section>
</div>
@endsection
