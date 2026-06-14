@extends('layouts.app')

@section('title','Hasil Penilaian Pribadi')
@section('page_title','Hasil Penilaian Pribadi')

@section('content')
<div class="dashboard-grid">
    <section class="hero-panel card hero-panel-personal">
        <div class="hero-panel-copy">
            <span class="section-pill">Personal Result</span>
            <h2>Nilai final Anda adalah {{ $latestRecap?->nilai_akhir ?? '91.2' }}</h2>
            <p>Grade {{ $latestRecap?->grade ?? 'A' }}, dengan performa paling kuat di Loyal dan Kolaboratif.</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip summary-chip-tight">
                <strong>{{ $latestRecap?->nilai_akhir ?? '91.2' }}</strong>
                <span>Final Score</span>
            </div>
            <div class="summary-chip summary-chip-tight">
                <strong>{{ $latestRecap?->grade ?? 'A' }}</strong>
                <span>Grade</span>
            </div>
        </div>
    </section>

    <section class="content-grid content-grid-wide">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">360 Composition</span>
                    <h3>Komposisi penilaian</h3>
                </div>
            </div>
            <div class="component-bars">
                <div class="component-row"><div class="component-label"><strong>Atasan Langsung</strong><span>40%</span></div><div class="component-track"><span style="width: 92%"></span></div><strong>92</strong></div>
                <div class="component-row"><div class="component-label"><strong>Rekan Sejawat</strong><span>20%</span></div><div class="component-track"><span style="width: 90%"></span></div><strong>90</strong></div>
                <div class="component-row"><div class="component-label"><strong>Bawahan</strong><span>30%</span></div><div class="component-track"><span style="width: 89%"></span></div><strong>89</strong></div>
                <div class="component-row"><div class="component-label"><strong>Self</strong><span>10%</span></div><div class="component-track"><span style="width: 94%"></span></div><strong>94</strong></div>
            </div>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Variable Score</span>
                    <h3>AKHLAK per variable</h3>
                </div>
            </div>
            <div class="variable-grid">
                <div class="variable-pill"><strong>Amanah</strong><span>92</span></div>
                <div class="variable-pill"><strong>Kompeten</strong><span>88</span></div>
                <div class="variable-pill"><strong>Harmonis</strong><span>90</span></div>
                <div class="variable-pill"><strong>Loyal</strong><span>95</span></div>
                <div class="variable-pill"><strong>Adaptif</strong><span>87</span></div>
                <div class="variable-pill"><strong>Kolaboratif</strong><span>93</span></div>
            </div>
        </div>
    </section>
</div>
@endsection
