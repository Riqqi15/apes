@extends('layouts.app')

@section('title','Dashboard HR')
@section('page_title','Dashboard HR')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const progressCtx = document.getElementById('hrProgressChart');
    const gradeCtx = document.getElementById('hrGradeChart');
    const performanceCtx = document.getElementById('hrPerformanceChart');

    if (progressCtx) {
        new Chart(progressCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($completionBars, 'label')) !!},
                datasets: [{
                    label: 'Progress',
                    data: {!! json_encode(array_column($completionBars, 'value')) !!},
                    borderRadius: 12,
                    backgroundColor: ['#f6c445', '#0b63ce', '#16a34a', '#d99a00'],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: 0 },
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0' } }, x: { grid: { display: false } } }
            }
        });
    }

    if (gradeCtx) {
        new Chart(gradeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($gradeLabels) !!},
                datasets: [{
                    data: {!! json_encode($gradeValues) !!},
                    backgroundColor: ['#16a34a', '#0b63ce', '#f6c445', '#dc2626'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: 0 },
                cutout: '72%',
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    if (performanceCtx) {
        new Chart(performanceCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($performanceLabels) !!},
                datasets: [{
                    label: 'Nilai',
                    data: {!! json_encode($performanceValues) !!},
                    backgroundColor: '#053b78',
                    borderRadius: 12,
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
    <section class="hero-panel card">
        <div class="hero-panel-copy">
            <span class="section-pill">HR Department</span>
            <h2>Kontrol penuh proses penilaian AKHLAK.</h2>
            <p>Monitoring cepat untuk data karyawan, variabel, indikator, dan progres penilaian lintas departemen.</p>
        </div>
        <div class="hero-panel-metrics">
            @foreach($progressCards as $card)
                <div class="mini-metric">
                    <span>{{ $card['label'] }}</span>
                    <strong>{{ $card['value'] }}</strong>
                </div>
            @endforeach
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
                    <span class="section-pill">Progress Penilaian</span>
                    <h3>Distribusi penyelesaian per departemen</h3>
                </div>
            </div>
            <div class="chart-wrap chart-wrap-lg">
                <canvas id="hrProgressChart"></canvas>
            </div>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Grade</span>
                    <h3>Grade distribution</h3>
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="hrGradeChart"></canvas>
            </div>
        </div>
    </section>

    <section class="content-grid">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Assessment Completion</span>
                    <h3>Progress by department</h3>
                </div>
            </div>
            <div class="stacked-bars">
                @foreach($completionBars as $bar)
                    <div class="stacked-row">
                        <div class="stacked-label">{{ $bar['label'] }}</div>
                        <div class="stacked-track"><span style="width: {{ $bar['value'] }}%"></span></div>
                        <strong>{{ $bar['value'] }}%</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Performance</span>
                    <h3>Nilai AKHLAK per variable</h3>
                </div>
            </div>
            <div class="chart-wrap chart-wrap-sm">
                <canvas id="hrPerformanceChart"></canvas>
            </div>
        </div>
    </section>

    <section class="content-grid content-grid-full">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Recent Activity</span>
                    <h3>Aktivitas karyawan terbaru</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table dashboard-table align-middle">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Departemen</th>
                            <th>Nilai Akhir</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topEmployees as $employee)
                            <tr>
                                <td class="fw-semibold">{{ $employee['name'] }}</td>
                                <td>{{ $employee['department'] }}</td>
                                <td>{{ $employee['score'] }}</td>
                                <td>@include('components.grade-badge', ['grade' => $employee['grade'], 'label' => $employee['grade']])</td>
                                <td><span class="status-pill status-pill-success">Selesai</span></td>
                                <td>Hari ini</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
