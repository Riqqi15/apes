@extends('layouts.app')

@section('title','Dashboard Karyawan')
@section('page_title','Dashboard Karyawan')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radarCtx = document.getElementById('karyawanRadarChart');
    const trendCtx = document.getElementById('karyawanTrendChart');

    if (radarCtx) {
        new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: {!! json_encode($radarLabels) !!},
                datasets: [{
                    label: 'Nilai',
                    data: {!! json_encode($radarValues) !!},
                    borderColor: '#053b78',
                    backgroundColor: 'rgba(246, 196, 69, 0.18)',
                    pointBackgroundColor: '#f6c445',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: 0 },
                scales: { r: { beginAtZero: true, max: 100, ticks: { display: false } } }
            }
        });
    }

    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendLabels) !!},
                datasets: [{
                    label: 'Skor',
                    data: {!! json_encode($trendValues) !!},
                    borderColor: '#0b63ce',
                    backgroundColor: 'rgba(11, 99, 206, 0.12)',
                    fill: true,
                    tension: 0.35,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: 0 },
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100, grid: { color: '#e2e8f0' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endpush

@section('content')
<div class="dashboard-grid">
    <section class="hero-panel card hero-panel-personal">
        <div class="hero-panel-copy">
            <span class="section-pill">Karyawan</span>
            <h2>Semua hasil pribadi, satu tempat.</h2>
            <p>Cek skor terbaru, grade, status penilaian, dan kontribusi Anda sebagai evaluator tanpa pindah halaman.</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip">
                <span>Latest score</span>
                <strong>91.2</strong>
            </div>
            <div class="summary-chip">
                <span>Latest grade</span>
                <strong>A</strong>
            </div>
            <div class="summary-chip">
                <span>Assessment done</span>
                <strong>2/4</strong>
            </div>
        </div>
    </section>

    <section class="stats-grid">
        @foreach($stats as $stat)
            @include('components.stat-card', $stat)
        @endforeach
    </section>

    <section class="charts-grid">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">AKHLAK Radar</span>
                    <h3>Perbandingan kompetensi</h3>
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="karyawanRadarChart"></canvas>
            </div>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Score Trend</span>
                    <h3>Perkembangan skor pribadi</h3>
                </div>
            </div>
            <div class="chart-wrap chart-wrap-lg">
                <canvas id="karyawanTrendChart"></canvas>
            </div>
        </div>
    </section>

    <section class="content-grid">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Assessment Queue</span>
                    <h3>Penilaian yang perlu Anda isi</h3>
                </div>
            </div>
            <div class="timeline-list">
                @foreach($evaluationQueue as $item)
                    <div class="timeline-row">
                        <div>
                            <strong>{{ $item['name'] }}</strong>
                            <span>{{ $item['role'] }}</span>
                        </div>
                        <span class="status-pill status-pill-{{ $item['status'] === 'Selesai' ? 'success' : 'warning' }}">{{ $item['status'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </section>
</div>
@endsection
