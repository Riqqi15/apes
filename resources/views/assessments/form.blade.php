@extends('layouts.app')

@section('title','Melakukan Penilaian')
@section('page_title','Melakukan Penilaian')

@section('content')
@php
    $renderedCompletedIndicators = collect($indicatorGroups)->sum(function ($group) use ($existingScores) {
        return collect($group['indicators'])->filter(function ($indicator) use ($existingScores) {
            return filled(old('scores.' . $indicator->id_indikator, $existingScores[$indicator->id_indikator] ?? null));
        })->count();
    });
@endphp

<div class="dashboard-grid">
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-0">{{ session('status') }}</div>
    @endif

    <section class="hero-panel card hero-panel-alt">
        <div class="hero-panel-copy">
            <span class="section-pill">Step 1</span>
            <h2>Isi penilaian untuk {{ $assignment->assessee?->nama_lengkap ?? 'karyawan' }}</h2>
            <p>Periode {{ $assignment->period?->nama_periode ?? '-' }}, tipe penilai {{ $assignment->jenis_penilai }}, dan skor akan langsung memperbarui rekap pribadi setelah Anda menyimpan.</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip summary-chip-tight">
                <span>Periode</span>
                <strong>{{ $assignment->period?->nama_periode ?? '-' }}</strong>
            </div>
            <div class="summary-chip summary-chip-tight">
                <span>Assessee</span>
                <strong>{{ $assignment->assessee?->nama_lengkap ?? '-' }}</strong>
            </div>
            <div class="summary-chip summary-chip-tight">
                <span>Status assignment</span>
                <strong>{{ $assignment->status }}</strong>
            </div>
        </div>
    </section>

    <section class="content-grid content-grid-wide assessment-layout">
        <div class="dashboard-card card assessment-main">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Step 2</span>
                    <h3>Skor per indikator</h3>
                </div>
                <div class="assessment-progress-copy">
                    <strong><span data-progress-count>{{ $renderedCompletedIndicators }}</span>/<span data-progress-total>{{ $totalIndicators }}</span></strong>
                    <span>indikator terisi</span>
                </div>
            </div>

            @if($existingScores !== [])
                <div class="alert alert-warning border-0 mx-4 mt-3 mb-0">
                    Anda sudah pernah menyimpan penilaian ini. Submit ulang akan menimpa skor lama dengan data terbaru.
                </div>
            @endif

            <form id="assessment-submit" method="POST" action="{{ route('penilaian.submit', $assignment) }}" class="assessment-form" data-assessment-form>
                @csrf
                @foreach($indicatorGroups as $group)
                    <section class="assessment-group">
                        <div class="assessment-group-head">
                            <div>
                                <span class="section-pill">{{ $group['label'] }}</span>
                                <h4>{{ $group['label'] }}</h4>
                            </div>
                            <small>{{ count($group['indicators']) }} indikator</small>
                        </div>

                        <div class="assessment-indicator-list">
                            @foreach($group['indicators'] as $indicator)
                                @php
                                    $selectedValue = old('scores.' . $indicator->id_indikator, $existingScores[$indicator->id_indikator] ?? null);
                                @endphp
                                <div class="assessment-indicator" data-indicator-card>
                                    <div class="assessment-indicator-head">
                                        <div class="assessment-indicator-copy">
                                            <strong>{{ $indicator->nama_indikator }}</strong>
                                            <span>{{ $indicator->nama_variabel_penilaian ?? 'Indikator AKHLAK' }}</span>
                                        </div>
                                    </div>
                                    <div class="assessment-score-options" data-score-group>
                                        @foreach($scoreOptions as $value => $option)
                                            <label class="assessment-score-option {{ (string) $selectedValue === (string) $value ? 'is-active' : '' }}" data-score-button>
                                                <input type="radio" name="scores[{{ $indicator->id_indikator }}]" value="{{ $value }}" @checked((string) $selectedValue === (string) $value)>
                                                <span>{{ $value }}</span>
                                                <small>{{ $option['label'] }}</small>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('scores.' . $indicator->id_indikator)
                                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach

                @error('scores')
                    <div class="alert alert-danger border-0 mx-4 mb-0">{{ $message }}</div>
                @enderror
            </form>
        </div>

        <aside class="dashboard-card card assessment-summary-panel">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Review</span>
                    <h3>Ringkasan sebelum simpan</h3>
                </div>
            </div>

            <div class="assessment-summary-body">
                <div class="assessment-review-grid">
                    <div class="assessment-review-item">
                        <span>Asesor</span>
                        <strong>{{ $assignment->assessor?->nama_lengkap ?? '-' }}</strong>
                    </div>
                    <div class="assessment-review-item">
                        <span>Tipe penilai</span>
                        <strong>{{ $assignment->jenis_penilai }}</strong>
                    </div>
                    <div class="assessment-review-item">
                        <span>Deadline</span>
                        <strong>{{ $assignment->deadline?->format('d M Y') ?? '-' }}</strong>
                    </div>
                    <div class="assessment-review-item">
                        <span>Status</span>
                        <strong>{{ $assignment->status }}</strong>
                    </div>
                </div>

                <div class="assessment-progress-box">
                    <div class="assessment-progress-bar">
                        <span data-progress-bar style="width: {{ $totalIndicators > 0 ? round(($renderedCompletedIndicators / $totalIndicators) * 100) : 0 }}%"></span>
                    </div>
                    <small>Progress pengisian</small>
                </div>

                <div class="assessment-note">
                    Semua perubahan akan langsung tersimpan ke rekap pribadi setelah tombol simpan ditekan.
                </div>

                <button type="submit" form="assessment-submit" class="btn btn-apes w-100 auth-submit">Simpan penilaian</button>
                <a href="{{ route('penilaian.assignments') }}" class="btn btn-outline-secondary w-100 mt-2">Kembali ke assignment</a>
            </div>
        </aside>
    </section>
</div>
@endsection
