@extends('layouts.app')

@section('title','Assignment Penilaian')
@section('page_title','Assignment Penilaian')

@section('content')
<div class="dashboard-grid">
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-0">{{ session('status') }}</div>
    @endif

    <section class="hero-panel card hero-panel-alt">
        <div class="hero-panel-copy">
            <span class="section-pill">Assignment</span>
            <h2>Daftar penilaian yang perlu Anda selesaikan</h2>
            <p>Pilih assignment yang aktif, isi skor indikator dengan cepat, lalu simpan hasil final tanpa kehilangan konteks periode maupun assessee.</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip summary-chip-tight">
                <span>Total assignment</span>
                <strong>{{ $assignmentStats['total'] }}</strong>
            </div>
            <div class="summary-chip summary-chip-tight">
                <span>Menunggu</span>
                <strong>{{ $assignmentStats['waiting'] }}</strong>
            </div>
            <div class="summary-chip summary-chip-tight">
                <span>Selesai</span>
                <strong>{{ $assignmentStats['completed'] }}</strong>
            </div>
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Queue</span>
                <h3>Assignment evaluator</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Assessor</th>
                        <th>Assessee</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Skor</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $assignment)
                        <tr>
                            <td class="fw-semibold">{{ $assignment->period?->nama_periode ?? '-' }}</td>
                            <td>
                                <div class="fw-semibold">{{ $assignment->assessor?->nama_lengkap ?? '-' }}</div>
                                <small class="text-secondary">{{ $assignment->assessor?->jabatan ?? 'Belum diatur' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $assignment->assessee?->nama_lengkap ?? '-' }}</div>
                                <small class="text-secondary">{{ $assignment->assessee?->departemen ?? 'Belum diatur' }}</small>
                            </td>
                            <td>{{ $assignment->jenis_penilai }}</td>
                            <td>
                                <span class="status-pill {{ $assignment->status === 'Selesai' ? 'status-pill-success' : ($assignment->status === 'Berjalan' ? 'status-pill-warning' : 'status-pill-neutral') }}">
                                    {{ $assignment->status }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $assignment->assessments_count }}</div>
                                <small class="text-secondary">indikator tersimpan</small>
                            </td>
                            <td>{{ $assignment->deadline?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <a href="{{ route('penilaian.form', $assignment) }}" class="btn btn-sm btn-apes">
                                    {{ $assignment->status === 'Selesai' ? 'Lihat / Ubah' : 'Mulai Nilai' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-secondary py-4">Belum ada assignment yang dialokasikan ke akun ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
