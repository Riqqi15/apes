@extends('layouts.app')

@section('title','Kelola Penilaian')
@section('page_title','Kelola Penilaian')

@php
    $editingPeriod = $editingPeriod ?? null;
    $editingAssignment = $editingAssignment ?? null;
@endphp

@push('head')
<style>
    .assessment-shell {
        display: grid;
        gap: 1rem;
    }

    .assessment-hero {
        position: relative;
        overflow: hidden;
        padding: 1.5rem;
        border: 1px solid rgba(5, 59, 120, 0.12);
        background:
            radial-gradient(circle at top right, rgba(246, 196, 69, 0.22), transparent 24%),
            radial-gradient(circle at bottom left, rgba(11, 99, 206, 0.12), transparent 22%),
            linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
    }

    .assessment-hero::after {
        content: "";
        position: absolute;
        inset: auto -4rem -5rem auto;
        width: 15rem;
        height: 15rem;
        border-radius: 50%;
        background: rgba(246, 196, 69, 0.12);
        filter: blur(8px);
        pointer-events: none;
    }

    .assessment-hero-copy {
        max-width: 60rem;
        display: grid;
        gap: 0.85rem;
        position: relative;
        z-index: 1;
    }

    .assessment-hero-copy h2 {
        margin: 0;
        font-size: clamp(1.8rem, 3vw, 2.6rem);
        font-weight: 900;
        letter-spacing: -0.03em;
    }

    .assessment-hero-copy p {
        margin: 0;
        max-width: 52rem;
        color: var(--apes-muted);
        line-height: 1.7;
    }

    .assessment-metrics {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.85rem;
        margin-top: 0.4rem;
        position: relative;
        z-index: 1;
    }

    .assessment-metric {
        padding: 0.95rem 1rem;
        border-radius: 18px;
        border: 1px solid rgba(5, 59, 120, 0.08);
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
    }

    .assessment-metric span {
        display: block;
        color: var(--apes-muted);
        font-size: 0.88rem;
        margin-top: 0.2rem;
    }

    .assessment-stack {
        display: grid;
        gap: 1rem;
    }

    .assessment-compact-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
        align-items: start;
    }

    .assessment-card {
        border: 1px solid var(--apes-border);
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .assessment-card-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.2rem 1.25rem 0;
    }

    .assessment-card-head h3 {
        margin: 0.45rem 0 0;
        font-size: 1.05rem;
        font-weight: 850;
        letter-spacing: -0.01em;
    }

    .assessment-card-body {
        padding: 1.15rem 1.25rem 1.25rem;
    }

    .editing-focus {
        scroll-margin-top: 7rem;
        box-shadow: 0 18px 44px rgba(246, 196, 69, 0.18);
        border-color: rgba(246, 196, 69, 0.45);
    }

    .assessment-note {
        color: var(--apes-muted);
        line-height: 1.65;
        margin: 0;
    }

    .assessment-compact-panel {
        padding: 1.15rem 1.25rem 1.25rem;
        display: grid;
        gap: 0.95rem;
    }

    .assessment-compact-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .assessment-compact-head h3 {
        margin: 0.45rem 0 0;
        font-size: 1.05rem;
        font-weight: 850;
        letter-spacing: -0.01em;
    }

    .assessment-compact-head p {
        margin: 0.3rem 0 0;
        color: var(--apes-muted);
        font-size: 0.9rem;
        line-height: 1.55;
    }

    .assessment-weight-list {
        display: grid;
        gap: 0.65rem;
    }

    .assessment-weight-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.65rem;
    }

    .weight-chip {
        padding: 0.85rem 0.9rem;
        border-radius: 16px;
        border: 1px solid rgba(246, 196, 69, 0.22);
        background: linear-gradient(135deg, #fff 0%, #fff9e6 100%);
        display: grid;
        gap: 0.12rem;
    }

    .weight-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 0.95rem 1rem;
        border-radius: 16px;
        background: linear-gradient(135deg, #fff 0%, #fff9e6 100%);
        border: 1px solid rgba(246, 196, 69, 0.22);
    }

    .weight-chip strong,
    .weight-item strong {
        display: block;
        font-size: 0.95rem;
    }

    .weight-chip span,
    .weight-item span {
        display: block;
        font-size: 0.86rem;
        color: var(--apes-muted);
    }

    .assessment-monitor-strip {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.65rem;
    }

    .monitor-mini {
        padding: 0.9rem 0.95rem;
        border-radius: 16px;
        border: 1px solid rgba(5, 59, 120, 0.08);
        background: #f8fbff;
        display: grid;
        gap: 0.12rem;
    }

    .monitor-mini strong {
        font-size: 1.05rem;
    }

    .monitor-mini span {
        color: var(--apes-muted);
        font-size: 0.85rem;
    }

    .period-form-grid {
        display: grid;
        grid-template-columns: 1.25fr 0.85fr 0.85fr 0.7fr;
        gap: 0.9rem;
    }

    .period-form-grid .form-control,
    .period-form-grid .form-select,
    .assignment-form-grid .form-control,
    .assignment-form-grid .form-select {
        min-height: 46px;
        border-radius: 14px;
    }

    .form-actions-inline {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        margin-top: 1.15rem;
    }

    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.38rem 0.75rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.02em;
    }

    .status-chip::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-chip-draft {
        color: var(--apes-muted);
        background: rgba(100, 116, 139, 0.12);
    }

    .status-chip-active {
        color: var(--apes-success);
        background: rgba(22, 163, 74, 0.12);
    }

    .status-chip-closed {
        color: var(--apes-danger);
        background: rgba(220, 38, 38, 0.12);
    }

    .status-chip-waiting {
        color: var(--apes-warning);
        background: rgba(245, 158, 11, 0.12);
    }

    .status-chip-running {
        color: var(--apes-blue);
        background: rgba(11, 99, 206, 0.12);
    }

    .assessment-table-wrap {
        overflow: hidden;
    }

    .assessment-table-wrap .dashboard-table tbody tr:hover {
        background: #fbfdff;
    }

    .assignment-form-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 0.9rem;
    }

    .assignment-form-grid .field-span-2 {
        grid-column: span 2;
    }

    .assignment-form-grid .field-span-3 {
        grid-column: span 3;
    }

    @media (max-width: 1199px) {
        .period-form-grid,
        .assignment-form-grid,
        .assessment-compact-grid,
        .assessment-weight-grid,
        .assessment-monitor-strip {
            grid-template-columns: 1fr;
        }

        .assignment-form-grid .field-span-2,
        .assignment-form-grid .field-span-3 {
            grid-column: auto;
        }

        .assessment-metrics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .assessment-metrics {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="assessment-shell">
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-0">
            {{ session('status') }}
        </div>
    @endif

    @php
        $duplicateAssignmentError = $errors->first('assignment_exists');
        $otherErrors = collect($errors->all())->reject(fn ($error) => $error === $duplicateAssignmentError);
    @endphp

    @if($duplicateAssignmentError)
        <div class="alert alert-danger border-0 shadow-sm mb-0">
            <strong>Assignment sudah ada.</strong>
            <div class="mt-1">{{ $duplicateAssignmentError }}</div>
        </div>
    @endif

    @if($otherErrors->isNotEmpty())
        <div class="alert alert-danger border-0 shadow-sm mb-0">
            <strong>Input belum rapi.</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach($otherErrors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="assessment-hero card">
        <div class="assessment-hero-copy">
            <span class="section-pill">Assessment Control</span>
            <h2>Kelola periode, assignment, dan bobot penilaian dalam satu workspace.</h2>
            <p>Halaman ini saya rapikan supaya HR bisa bergerak cepat: bikin periode, distribusi assessor, lalu pantau status tanpa layout yang saling berebut ruang.</p>
            <div class="assessment-metrics">
                <div class="assessment-metric">
                    <strong>{{ $periodStats['total'] }}</strong>
                    <span>Total periode</span>
                </div>
                <div class="assessment-metric">
                    <strong>{{ $periodStats['active'] }}</strong>
                    <span>Periode aktif</span>
                </div>
                <div class="assessment-metric">
                    <strong>{{ $assignmentStats['total'] }}</strong>
                    <span>Total assignment</span>
                </div>
                <div class="assessment-metric">
                    <strong>{{ $assignmentStats['completed'] }}</strong>
                    <span>Assignment selesai</span>
                </div>
            </div>
        </div>
    </section>

    <section class="assessment-stack">
        <article class="assessment-card {{ $editingPeriod ? 'editing-focus' : '' }}" id="period-form-card">
            <div class="assessment-card-head">
                <div>
                    <span class="section-pill">Period Management</span>
                    <h3>{{ $editingPeriod ? 'Edit periode penilaian' : 'Tambah periode penilaian' }}</h3>
                </div>
            </div>
            <div class="assessment-card-body">
                @if($editingPeriod)
                    <div class="alert alert-warning border-0 shadow-sm mb-4">
                        Anda sedang mengedit periode <strong>{{ $editingPeriod->nama_periode }}</strong>. Ubah field yang diperlukan lalu klik <strong>Simpan Perubahan</strong>.
                    </div>
                @endif
                <p class="assessment-note mb-4">Gunakan form ini untuk membuka, menutup, atau memperbarui periode penilaian yang sedang aktif.</p>
                <form method="POST" action="{{ $editingPeriod ? route('kelola.penilaian.periods.update', $editingPeriod) : route('kelola.penilaian.periods.store') }}">
                    @csrf
                    @if($editingPeriod)
                        @method('PUT')
                    @endif
                    <div class="period-form-grid">
                        <div>
                            <label class="form-label fw-semibold">Nama Periode</label>
                            <input class="form-control" name="nama_periode" type="text" value="{{ old('nama_periode', $editingPeriod?->nama_periode) }}" placeholder="Triwulan II 2026">
                        </div>
                        <div>
                            <label class="form-label fw-semibold">Mulai</label>
                            <input class="form-control" name="tanggal_mulai" type="date" value="{{ old('tanggal_mulai', optional($editingPeriod?->tanggal_mulai)->format('Y-m-d')) }}">
                        </div>
                        <div>
                            <label class="form-label fw-semibold">Selesai</label>
                            <input class="form-control" name="tanggal_selesai" type="date" value="{{ old('tanggal_selesai', optional($editingPeriod?->tanggal_selesai)->format('Y-m-d')) }}">
                        </div>
                        <div>
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status">
                                @foreach(['draft' => 'Draft', 'active' => 'Aktif', 'closed' => 'Closed'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $editingPeriod?->status ?? 'draft') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-actions-inline">
                        <button class="btn btn-apes" type="submit">{{ $editingPeriod ? 'Simpan Perubahan' : 'Simpan Periode' }}</button>
                        @if($editingPeriod)
                            <a href="{{ route('kelola.penilaian') }}" class="btn btn-outline-secondary">Batal Edit</a>
                        @else
                            <button class="btn btn-outline-secondary" type="reset">Reset</button>
                        @endif
                    </div>
                </form>
            </div>
        </article>

        <div class="assessment-compact-grid">
            <aside class="assessment-card">
                <div class="assessment-compact-panel">
                    <div class="assessment-compact-head">
                        <div>
                            <span class="section-pill">Weight Config</span>
                            <h3>Bobot 360 yang dipakai</h3>
                            <p>Komposisi aktif untuk seluruh periode penilaian.</p>
                        </div>
                    </div>
                    <div class="assessment-weight-grid">
                        <div class="weight-chip">
                            <strong>Atasan Langsung</strong>
                            <span>40%</span>
                        </div>
                        <div class="weight-chip">
                            <strong>Rekan Sejawat</strong>
                            <span>20%</span>
                        </div>
                        <div class="weight-chip">
                            <strong>Bawahan</strong>
                            <span>30%</span>
                        </div>
                        <div class="weight-chip">
                            <strong>Self Assessment</strong>
                            <span>10%</span>
                        </div>
                    </div>
                    <div class="assessment-weight-foot">Komposisi aktif untuk seluruh periode penilaian.</div>
                </div>
            </aside>

            <aside class="assessment-card">
                <div class="assessment-compact-panel">
                    <div class="assessment-compact-head">
                        <div>
                            <span class="section-pill">Assignment Monitor</span>
                            <h3>Rangkuman penugasan</h3>
                            <p>Ringkasan cepat status assignment yang sedang berjalan.</p>
                        </div>
                    </div>
                    <div class="assessment-monitor-strip">
                        <div class="monitor-mini">
                            <strong>{{ $assignmentStats['total'] }}</strong>
                            <span>Total assignment</span>
                        </div>
                        <div class="monitor-mini">
                            <strong>{{ $assignmentStats['waiting'] }}</strong>
                            <span>Menunggu</span>
                        </div>
                        <div class="monitor-mini">
                            <strong>{{ $assignmentStats['completed'] }}</strong>
                            <span>Selesai</span>
                        </div>
                        <div class="monitor-mini">
                            <strong>{{ $assignmentStats['total'] > 0 ? number_format(($assignmentStats['completed'] / max($assignmentStats['total'], 1)) * 100, 0) : 0 }}%</strong>
                            <span>Coverage</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        <article class="assessment-card">
            <div class="assessment-card-head">
                <div>
                    <span class="section-pill">Period List</span>
                    <h3>Daftar periode penilaian</h3>
                </div>
            </div>
            <div class="assessment-card-body assessment-table-wrap">
                <div class="table-responsive">
                    <table class="table dashboard-table align-middle">
                        <thead>
                            <tr>
                                <th>Nama Periode</th>
                                <th>Rentang</th>
                                <th>Status</th>
                                <th>Assignment</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($periods as $period)
                                <tr>
                                    <td class="fw-semibold">{{ $period->nama_periode }}</td>
                                    <td>{{ $period->tanggal_mulai->format('d M Y') }} - {{ $period->tanggal_selesai->format('d M Y') }}</td>
                                    <td>
                                        <span class="status-chip {{ $period->status === 'active' ? 'status-chip-active' : ($period->status === 'closed' ? 'status-chip-closed' : 'status-chip-draft') }}">
                                            {{ ucfirst($period->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $period->assignments_count }} assignment</td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('kelola.penilaian', ['edit_period' => $period->id_periode]) }}#period-form-card" class="action-btn action-btn-edit" title="Edit">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="m12 20 8-8"></path>
                                                    <path d="M14.5 5.5 18.5 9.5"></path>
                                                    <path d="M4 20h5"></path>
                                                    <path d="M4 16.5 14.5 6 18 9.5 7.5 20H4z"></path>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('kelola.penilaian.periods.destroy', $period) }}" onsubmit="return confirm('Hapus periode ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn action-btn-delete" title="Hapus">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M3 6h18"></path>
                                                        <path d="M8 6V4h8v2"></path>
                                                        <path d="M6 6l1 14h10l1-14"></path>
                                                        <path d="M10 11v6"></path>
                                                        <path d="M14 11v6"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-4">Belum ada periode penilaian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </section>

    <section class="assessment-card {{ $editingAssignment ? 'editing-focus' : '' }}" id="assignment-form-card">
        <div class="assessment-card-head">
            <div>
                <span class="section-pill">Assignment Setup</span>
                <h3>{{ $editingAssignment ? 'Edit assignment assessor' : 'Buat assignment assessor' }}</h3>
            </div>
        </div>
        <div class="assessment-card-body">
            @if($editingAssignment)
                <div class="alert alert-warning border-0 shadow-sm mb-4">
                    Anda sedang mengedit assignment untuk <strong>{{ $editingAssignment->assessee?->nama_lengkap ?? 'karyawan' }}</strong>. Setelah selesai, simpan perubahan di bawah ini.
                </div>
            @endif
            <p class="assessment-note mb-4">Susun siapa menilai siapa sebelum assessment dibuka. Tipe self assessment otomatis menuntut assessor dan assessee yang sama.</p>
            <form method="POST" action="{{ $editingAssignment ? route('kelola.penilaian.assignments.update', $editingAssignment) : route('kelola.penilaian.assignments.store') }}">
                @csrf
                @if($editingAssignment)
                    @method('PUT')
                @endif
                <div class="assignment-form-grid">
                    <div class="field-span-2">
                        <label class="form-label fw-semibold">Periode</label>
                        <select class="form-select" name="id_periode">
                            <option value="">Pilih periode</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id_periode }}" @selected((string) old('id_periode', $editingAssignment?->id_periode) === (string) $period->id_periode)>{{ $period->nama_periode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-span-2">
                        <label class="form-label fw-semibold">Assessor</label>
                        <select class="form-select" name="assessor_id">
                            <option value="">Pilih assessor</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id_karyawan }}" @selected((string) old('assessor_id', $editingAssignment?->assessor_id) === (string) $employee->id_karyawan)>{{ $employee->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-span-2">
                        <label class="form-label fw-semibold">Assessee</label>
                        <select class="form-select" name="assessee_id">
                            <option value="">Pilih karyawan dinilai</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id_karyawan }}" @selected((string) old('assessee_id', $editingAssignment?->assessee_id) === (string) $employee->id_karyawan)>{{ $employee->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-span-2">
                        <label class="form-label fw-semibold">Tipe Penilai</label>
                        <select class="form-select" name="jenis_penilai">
                            <option value="">Pilih tipe</option>
                            @foreach($roleTypes as $type)
                                <option value="{{ $type }}" @selected(old('jenis_penilai', $editingAssignment?->jenis_penilai) === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" name="status">
                            @foreach($statusOptions as $status)
                                <option value="{{ $status }}" @selected(old('status', $editingAssignment?->status ?? 'Menunggu') === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Deadline</label>
                        <input class="form-control" name="deadline" type="date" value="{{ old('deadline', optional($editingAssignment?->deadline)->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="form-actions-inline">
                    <button class="btn btn-apes" type="submit">{{ $editingAssignment ? 'Simpan Assignment' : 'Tambah Assignment' }}</button>
                    @if($editingAssignment)
                        <a href="{{ route('kelola.penilaian') }}" class="btn btn-outline-secondary">Batal Edit</a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <section class="assessment-card">
        <div class="assessment-card-head">
            <div>
                <span class="section-pill">Assignment List</span>
                <h3>Daftar assignment assessor</h3>
            </div>
        </div>
        <div class="assessment-card-body assessment-table-wrap">
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
                            <th>Aksi</th>
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
                                    <span class="status-chip {{ $assignment->status === 'Selesai' ? 'status-chip-active' : ($assignment->status === 'Berjalan' ? 'status-chip-running' : 'status-chip-waiting') }}">
                                        {{ $assignment->status }}
                                    </span>
                                </td>
                                <td>{{ $assignment->deadline?->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('kelola.penilaian', ['edit_assignment' => $assignment->id_assignment]) }}#assignment-form-card" class="action-btn action-btn-edit" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="m12 20 8-8"></path>
                                                <path d="M14.5 5.5 18.5 9.5"></path>
                                                <path d="M4 20h5"></path>
                                                <path d="M4 16.5 14.5 6 18 9.5 7.5 20H4z"></path>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('kelola.penilaian.assignments.destroy', $assignment) }}" onsubmit="return confirm('Hapus assignment ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-btn-delete" title="Hapus">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M8 6V4h8v2"></path>
                                                    <path d="M6 6l1 14h10l1-14"></path>
                                                    <path d="M10 11v6"></path>
                                                    <path d="M14 11v6"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-secondary py-4">Belum ada assignment assessor.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
