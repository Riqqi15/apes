@extends('layouts.app')

@section('title','Kelola Indikator')
@section('page_title','Kelola Indikator')

@section('content')
<div class="dashboard-grid">
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-0">{{ session('status') }}</div>
    @endif

    <section class="content-grid content-grid-wide management-grid">
        <div class="dashboard-card card management-form-card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">{{ $editingIndicator ? 'Edit Indicator' : 'Tambah Indicator' }}</span>
                    <h3>{{ $editingIndicator ? 'Perbarui indikator penilaian' : 'Tambah indikator penilaian baru' }}</h3>
                </div>
                @if($editingIndicator)
                    <a href="{{ route('kelola.indikator', array_filter(['search' => $filters['search'], 'variable' => $filters['variable']])) }}" class="btn btn-outline-secondary">Batal</a>
                @endif
            </div>
            <form class="management-form" method="POST" action="{{ $editingIndicator ? route('kelola.indikator.update', $editingIndicator->id_indikator) : route('kelola.indikator.store') }}">
                @csrf
                @if($editingIndicator)
                    @method('PUT')
                @endif

                <div class="form-field">
                    <label class="form-label" for="id_variabel">Variabel</label>
                    <select id="id_variabel" name="id_variabel" class="form-select @error('id_variabel') is-invalid @enderror">
                        <option value="">Pilih variabel AKHLAK</option>
                        @foreach($variables as $variable)
                            <option value="{{ $variable->id_variabel }}" @selected((string) old('id_variabel', $editingIndicator->id_variabel ?? '') === (string) $variable->id_variabel)>
                                {{ $variable->nama_variabel }} ({{ $variable->indikator_count }} indikator)
                            </option>
                        @endforeach
                    </select>
                    @error('id_variabel')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="form-label" for="nama_indikator">Nama indikator</label>
                    <textarea
                        id="nama_indikator"
                        name="nama_indikator"
                        rows="4"
                        class="form-control @error('nama_indikator') is-invalid @enderror"
                        placeholder="Contoh: Menjaga integritas dan amanah dalam bekerja"
                    >{{ old('nama_indikator', $editingIndicator->nama_indikator ?? '') }}</textarea>
                    @error('nama_indikator')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="form-label" for="nama_variabel_penilaian">Label ringkas penilaian</label>
                    <input
                        id="nama_variabel_penilaian"
                        name="nama_variabel_penilaian"
                        type="text"
                        class="form-control @error('nama_variabel_penilaian') is-invalid @enderror"
                        value="{{ old('nama_variabel_penilaian', $editingIndicator->nama_variabel_penilaian ?? '') }}"
                        placeholder="Kosongkan untuk memakai nama variabel"
                    >
                    @error('nama_variabel_penilaian')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-apes {{ $editingIndicator ? '' : 'btn-with-icon' }}">
                        @if(!$editingIndicator)
                            <span class="material-symbols-rounded">add</span>
                        @endif
                        <span>{{ $editingIndicator ? 'Simpan Perubahan' : 'Tambah Indikator' }}</span>
                    </button>
                    <a href="{{ route('kelola.variabel') }}" class="btn btn-outline-secondary">Lihat Variabel</a>
                </div>
            </form>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">Indicator Summary</span>
                    <h3>Ringkasan library indikator</h3>
                </div>
            </div>
            <div class="indicator-summary-grid">
                <div class="indicator-summary-card">
                    <span>Total indikator</span>
                    <strong>{{ $indicatorStats['total'] }}</strong>
                </div>
                <div class="indicator-summary-card">
                    <span>Hasil filter</span>
                    <strong>{{ $indicatorStats['filtered'] }}</strong>
                </div>
                <div class="indicator-summary-card">
                    <span>Tanpa label ringkas</span>
                    <strong>{{ $indicatorStats['withoutAlias'] }}</strong>
                </div>
                <div class="indicator-summary-card">
                    <span>Total variabel</span>
                    <strong>{{ $variables->count() }}</strong>
                </div>
            </div>
            <div class="assessment-note mx-4 mb-4">
                Gunakan filter variabel untuk merapikan indikator per nilai AKHLAK dan gunakan label ringkas agar tampilan form penilaian lebih mudah dipindai.
            </div>
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Indicator Library</span>
                <h3>Kelola indikator penilaian</h3>
            </div>
        </div>
        <form class="row g-3 px-4 pb-4 pt-3" method="GET">
            <div class="col-md-5">
                <input class="form-control" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari indikator atau label ringkas">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="variable">
                    <option value="">Semua Variabel</option>
                    @foreach($variables as $variable)
                        <option value="{{ $variable->id_variabel }}" @selected((string) ($filters['variable'] ?? '') === (string) $variable->id_variabel)>{{ $variable->nama_variabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-apes btn-with-icon" type="submit">
                    <span class="material-symbols-rounded">filter_alt</span>
                    <span>Filter</span>
                </button>
                <a class="btn btn-outline-secondary" href="{{ route('kelola.indikator') }}">Reset</a>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Variabel</th>
                        <th>Indikator</th>
                        <th>Label Ringkas</th>
                        <th>Status</th>
                        <th>Diperbarui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($indicators as $indicator)
                        <tr>
                            <td class="fw-semibold">{{ $indicator->variabel?->nama_variabel ?? '-' }}</td>
                            <td>{{ $indicator->nama_indikator }}</td>
                            <td>{{ $indicator->nama_variabel_penilaian ?? '-' }}</td>
                            <td><span class="status-pill status-pill-success">Aktif</span></td>
                            <td>{{ optional($indicator->updated_at)->format('d M Y') ?? '-' }}</td>
                            <td>
                                @include('components.table-actions', [
                                    'edit' => route('kelola.indikator', array_filter([
                                        'edit' => $indicator->id_indikator,
                                        'search' => $filters['search'],
                                        'variable' => $filters['variable'],
                                    ])),
                                    'delete' => route('kelola.indikator.destroy', $indicator->id_indikator),
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">Belum ada indikator penilaian yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-note">
            <span>Menampilkan {{ $indicators->count() }} dari {{ $indicators->total() }} indikator</span>
            {{ $indicators->links('pagination::bootstrap-5') }}
        </div>
    </section>
</div>
@endsection
