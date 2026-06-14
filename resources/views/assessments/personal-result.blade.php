@extends('layouts.app')

@section('title','Hasil Penilaian Pribadi')
@section('page_title','Hasil Penilaian Pribadi')

@section('content')
<div class="dashboard-grid">
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-0">{{ session('status') }}</div>
    @endif

    @if(! $hasResult)
        <section class="hero-panel card hero-panel-personal">
            <div class="hero-panel-copy">
                <span class="section-pill">Personal Result</span>
                <h2>Belum ada hasil penilaian yang bisa ditampilkan</h2>
                <p>Setelah assignment Anda diselesaikan, nilai final, grade, dan komposisi AKHLAK akan muncul di halaman ini.</p>
            </div>
            <div class="hero-panel-summary">
                <a href="{{ route('penilaian.assignments') }}" class="btn btn-apes auth-submit">Lihat assignment</a>
            </div>
        </section>
    @else
        <section class="hero-panel card hero-panel-personal">
            <div class="hero-panel-copy">
                <span class="section-pill">Personal Result</span>
                <h2>Nilai final Anda {{ number_format((float) $latestRecap->nilai_akhir, 1) }}</h2>
                <p>Grade {{ $latestRecap->grade }}, periode {{ $latestRecap->period?->nama_periode ?? '-' }}. Semua komponen sudah dihitung dari data penilaian terbaru.</p>
            </div>
            <div class="hero-panel-summary">
                <div class="summary-chip summary-chip-tight">
                    <strong>{{ number_format((float) $latestRecap->nilai_akhir, 1) }}</strong>
                    <span>Final score</span>
                </div>
                <div class="summary-chip summary-chip-tight">
                    <strong>{{ $latestRecap->grade }}</strong>
                    <span>Grade</span>
                </div>
                <div class="summary-chip summary-chip-tight">
                    <strong>{{ $latestRecap->period?->nama_periode ?? '-' }}</strong>
                    <span>Periode</span>
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
                    @foreach($componentScores as $component)
                        <div class="component-row">
                            <div class="component-label">
                                <strong>{{ $component['label'] }}</strong>
                                <span>{{ $component['weight'] }}</span>
                            </div>
                            <div class="component-track">
                                <span style="width: {{ max(0, min(100, (float) $component['value'])) }}%"></span>
                            </div>
                            <strong>{{ number_format((float) $component['value'], 1) }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="dashboard-card card">
                <div class="dashboard-card-head">
                    <div>
                        <span class="section-pill">Variable Score</span>
                        <h3>AKHLAK per variabel</h3>
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
            </div>
        </section>

        <section class="content-grid">
            <div class="dashboard-card card">
                <div class="dashboard-card-head">
                    <div>
                        <span class="section-pill">Recent Assignment</span>
                        <h3>Riwayat evaluator</h3>
                    </div>
                </div>
                <div class="timeline-list">
                    @forelse($recentAssignments as $assignment)
                        <div class="timeline-row">
                            <div>
                                <strong>{{ $assignment->period?->nama_periode ?? '-' }}</strong>
                                <span>{{ $assignment->jenis_penilai }} oleh {{ $assignment->assessor?->nama_lengkap ?? '-' }}</span>
                            </div>
                            <span class="status-pill {{ $assignment->status === 'Selesai' ? 'status-pill-success' : 'status-pill-warning' }}">{{ $assignment->status }}</span>
                        </div>
                    @empty
                        <div class="text-secondary">Belum ada riwayat assignment.</div>
                    @endforelse
                </div>
            </div>

            <div class="dashboard-card card">
                <div class="dashboard-card-head">
                    <div>
                        <span class="section-pill">Grade Guide</span>
                        <h3>Legenda kategori grade</h3>
                    </div>
                </div>
                <div class="detail-list">
                    @foreach($gradeLegend as $item)
                        <div>
                            <strong>Grade {{ $item['grade'] }} - {{ $item['label'] }}</strong>
                            <span>{{ $item['range'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
@endsection
