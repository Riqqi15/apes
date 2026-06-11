@extends('layouts.app')

@section('title','Dashboard Direktur')
@section('page_title','Dashboard Direktur')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const gradeCtx = document.getElementById('directorGradeChart');
    const variableCtx = document.getElementById('directorVariableChart');

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
                cutout: '70%',
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    if (variableCtx) {
        new Chart(variableCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($variableLabels) !!},
                datasets: [{
                    label: 'Skor',
                    data: {!! json_encode($variableValues) !!},
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
    <section class="hero-panel card hero-panel-alt">
        <div class="hero-panel-copy">
            <span class="section-pill">Direktur</span>
            <h2>Ringkasan kepemimpinan yang cepat dibaca.</h2>
            <p>Distribusi grade, performa tiap variable AKHLAK, dan daftar top employee siap untuk presentasi pimpinan.</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip">
                <strong>112</strong>
                <span>Selesai</span>
            </div>
            <div class="summary-chip">
                <strong>36</strong>
                <span>Pending</span>
            </div>
            <div class="summary-chip">
                <strong>86.4</strong>
                <span>Average</span>
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
                    <span class="section-pill">Grade Distribution</span>
                    <h3>Sebaran grade kinerja</h3>
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="directorGradeChart"></canvas>
            </div>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Variable Score</span>
                    <h3>AKHLAK variable performance</h3>
                </div>
            </div>
            <div class="chart-wrap chart-wrap-lg">
                <canvas id="directorVariableChart"></canvas>
            </div>
        </div>
    </section>

    <section class="content-grid">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Top 5</span>
                    <h3>Top employees</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table dashboard-table align-middle">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Departemen</th>
                            <th>Skor</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topEmployees as $employee)
                            <tr>
                                <td class="fw-semibold">{{ $employee['name'] }}</td>
                                <td>{{ $employee['department'] }}</td>
                                <td>{{ $employee['score'] }}</td>
                                <td>@include('components.grade-badge', ['grade' => $employee['grade'], 'label' => $employee['grade']])</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Department Ranking</span>
                    <h3>Rata-rata per departemen</h3>
                </div>
            </div>
            <div class="ranking-list">
                @foreach($departmentRanking as $department)
                    <div class="ranking-item">
                        <div>
                            <strong>{{ $department['name'] }}</strong>
                            <span>Overall score</span>
                        </div>
                        <strong>{{ $department['score'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
