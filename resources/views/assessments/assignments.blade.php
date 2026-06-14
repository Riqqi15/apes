@extends('layouts.app')

@section('title','Assignment Penilaian')
@section('page_title','Assignment Penilaian')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Assignment</span>
                <h3>Penugasan evaluator yang masuk ke akun Anda</h3>
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
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $assignment)
                        <tr>
                            <td class="fw-semibold">{{ $assignment->period?->nama_periode ?? '-' }}</td>
                            <td>{{ $assignment->assessor?->nama_lengkap ?? '-' }}</td>
                            <td>{{ $assignment->assessee?->nama_lengkap ?? '-' }}</td>
                            <td>{{ $assignment->jenis_penilai }}</td>
                            <td>
                                <span class="status-pill {{ $assignment->status === 'Selesai' ? 'status-pill-success' : ($assignment->status === 'Berjalan' ? 'status-pill-warning' : 'status-pill-neutral') }}">
                                    {{ $assignment->status }}
                                </span>
                            </td>
                            <td>{{ $assignment->deadline?->format('d M Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">Belum ada assignment yang dialokasikan ke akun ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
