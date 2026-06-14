@extends('layouts.app')

@section('title','Edit Penilaian')
@section('page_title','Edit Penilaian')

@section('content')
<div class="dashboard-grid">
    <section class="hero-panel card hero-panel-alt">
        <div class="hero-panel-copy">
            <span class="section-pill">Edit Recap</span>
            <h2>{{ $employee?->nama_lengkap ?? 'Karyawan' }}</h2>
            <p>{{ $employee?->departemen ?? 'Belum diatur' }} - {{ $employee?->jabatan ?? 'Belum diatur' }}. Perbarui komponen skor, lalu sistem akan menghitung ulang final score dan grade.</p>
        </div>
        <div class="hero-panel-summary">
            <div class="summary-chip summary-chip-tight">
                <span>Final Score</span>
                <strong id="previewFinal">{{ $preview['final'] }}</strong>
            </div>
            <div class="summary-chip summary-chip-tight">
                <span>Grade</span>
                <strong id="previewGrade">{{ $preview['grade'] }}</strong>
            </div>
        </div>
    </section>

    <section class="content-grid content-grid-wide">
        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Score Editor</span>
                    <h3>Perbarui komponen penilaian</h3>
                </div>
            </div>
            <form method="POST" action="{{ route('rekap.update', $rekap->id_rekap) }}" class="p-4 pt-0">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Periode</label>
                        <select class="form-select" name="id_periode">
                            <option value="">Gunakan periode saat ini</option>
                            @foreach($periods as $period)
                                <option value="{{ $period['value'] }}" @selected((string) old('id_periode', $rekap->id_periode) === (string) $period['value'])>{{ $period['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Atasan Langsung</label>
                        <input class="form-control score-input" name="nilai_atasan" type="number" min="0" max="100" step="0.1" value="{{ old('nilai_atasan', $rekap->nilai_atasan) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Rekan Sejawat</label>
                        <input class="form-control score-input" name="nilai_peer" type="number" min="0" max="100" step="0.1" value="{{ old('nilai_peer', $rekap->nilai_peer) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Bawahan</label>
                        <input class="form-control score-input" name="nilai_bawahan" type="number" min="0" max="100" step="0.1" value="{{ old('nilai_bawahan', $rekap->nilai_bawahan) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Self Assessment</label>
                        <input class="form-control score-input" name="nilai_self" type="number" min="0" max="100" step="0.1" value="{{ old('nilai_self', $rekap->nilai_self) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Keterangan Sistem</label>
                        <div class="form-control bg-light d-flex align-items-center" style="min-height: 46px;">
                            Bobot otomatis: 40% / 20% / 30% / 10%
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2 flex-wrap">
                    <button class="btn btn-apes" type="submit">Simpan Penilaian</button>
                    <a href="{{ route('rekap.show', $rekap->id_rekap) }}" class="btn btn-outline-secondary">Kembali ke Detail</a>
                </div>
            </form>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Preview</span>
                    <h3>Preview hasil setelah update</h3>
                </div>
            </div>
            <div class="component-bars">
                <div class="component-row">
                    <div class="component-label">
                        <strong>Atasan Langsung</strong>
                        <span>40%</span>
                    </div>
                    <div class="component-track"><span id="trackAtasan" style="width: {{ (float) $rekap->nilai_atasan }}%"></span></div>
                    <strong id="valueAtasan">{{ number_format((float) $rekap->nilai_atasan, 1) }}</strong>
                </div>
                <div class="component-row">
                    <div class="component-label">
                        <strong>Rekan Sejawat</strong>
                        <span>20%</span>
                    </div>
                    <div class="component-track"><span id="trackPeer" style="width: {{ (float) $rekap->nilai_peer }}%"></span></div>
                    <strong id="valuePeer">{{ number_format((float) $rekap->nilai_peer, 1) }}</strong>
                </div>
                <div class="component-row">
                    <div class="component-label">
                        <strong>Bawahan</strong>
                        <span>30%</span>
                    </div>
                    <div class="component-track"><span id="trackBawahan" style="width: {{ (float) $rekap->nilai_bawahan }}%"></span></div>
                    <strong id="valueBawahan">{{ number_format((float) $rekap->nilai_bawahan, 1) }}</strong>
                </div>
                <div class="component-row">
                    <div class="component-label">
                        <strong>Self Assessment</strong>
                        <span>10%</span>
                    </div>
                    <div class="component-track"><span id="trackSelf" style="width: {{ (float) $rekap->nilai_self }}%"></span></div>
                    <strong id="valueSelf">{{ number_format((float) $rekap->nilai_self, 1) }}</strong>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    (() => {
        const inputs = {
            atasan: document.querySelector('[name="nilai_atasan"]'),
            peer: document.querySelector('[name="nilai_peer"]'),
            bawahan: document.querySelector('[name="nilai_bawahan"]'),
            self: document.querySelector('[name="nilai_self"]'),
        };

        const outputs = {
            final: document.getElementById('previewFinal'),
            grade: document.getElementById('previewGrade'),
            atasan: document.getElementById('valueAtasan'),
            peer: document.getElementById('valuePeer'),
            bawahan: document.getElementById('valueBawahan'),
            self: document.getElementById('valueSelf'),
            trackAtasan: document.getElementById('trackAtasan'),
            trackPeer: document.getElementById('trackPeer'),
            trackBawahan: document.getElementById('trackBawahan'),
            trackSelf: document.getElementById('trackSelf'),
        };

        const gradeFor = (score) => {
            if (score >= 90) return 'A';
            if (score >= 80) return 'B';
            if (score >= 70) return 'C';
            return 'D';
        };

        const read = (input) => {
            const value = parseFloat(input.value || '0');
            return Number.isFinite(value) ? Math.min(100, Math.max(0, value)) : 0;
        };

        const update = () => {
            const scores = {
                atasan: read(inputs.atasan),
                peer: read(inputs.peer),
                bawahan: read(inputs.bawahan),
                self: read(inputs.self),
            };

            const finalScore = ((scores.atasan * 0.4) + (scores.peer * 0.2) + (scores.bawahan * 0.3) + (scores.self * 0.1)).toFixed(1);

            outputs.final.textContent = finalScore;
            outputs.grade.textContent = gradeFor(parseFloat(finalScore));
            outputs.atasan.textContent = scores.atasan.toFixed(1);
            outputs.peer.textContent = scores.peer.toFixed(1);
            outputs.bawahan.textContent = scores.bawahan.toFixed(1);
            outputs.self.textContent = scores.self.toFixed(1);
            outputs.trackAtasan.style.width = `${scores.atasan}%`;
            outputs.trackPeer.style.width = `${scores.peer}%`;
            outputs.trackBawahan.style.width = `${scores.bawahan}%`;
            outputs.trackSelf.style.width = `${scores.self}%`;
        };

        Object.values(inputs).forEach((input) => input?.addEventListener('input', update));
        update();
    })();
</script>
@endpush
