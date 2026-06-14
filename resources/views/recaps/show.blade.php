@extends('layouts.app')

@section('title','Detail Rekap')
@section('page_title','Detail Rekap')

@section('content')
<div class="dashboard-grid">
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-0">{{ session('status') }}</div>
    @endif

    <section class="hero-panel card hero-panel-print">
        <div class="hero-panel-copy">
            <span class="section-pill">Detail Hasil</span>
            <h2>{{ $employee['name'] }}</h2>
            <p>{{ $employee['department'] }} - {{ $employee['position'] }} - {{ $employee['period'] }}</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip summary-chip-tight">
                <span>Final Score</span>
                <strong>{{ $employee['finalScore'] }}</strong>
            </div>
            <div class="summary-chip summary-chip-tight">
                <span>Grade</span>
                @include('components.grade-badge', ['grade' => $employee['grade'], 'label' => $employee['grade']])
            </div>
            <a href="{{ $editUrl }}" class="btn btn-apes">Edit Penilaian</a>
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
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Print Access</span>
                <h3>Cetak hanya dari halaman rekap</h3>
            </div>
        </div>
        <div class="p-4 pt-0 text-secondary">
            Gunakan icon print pada tabel rekap penilaian untuk membuka versi cetak yang tervalidasi.
        </div>
    </section>
</div>
@endsection
