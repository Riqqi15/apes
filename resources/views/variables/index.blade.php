@extends('layouts.app')

@section('title','Kelola Variabel')
@section('page_title','Kelola Variabel')

@section('content')
@php
    $variableIcons = [
        'Amanah' => 'verified_user',
        'Kompeten' => 'workspace_premium',
        'Harmonis' => 'handshake',
        'Loyal' => 'military_tech',
        'Adaptif' => 'autorenew',
        'Kolaboratif' => 'groups',
    ];
@endphp
<div class="dashboard-grid">
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-0">{{ session('status') }}</div>
    @endif

    <section class="stats-grid">
        @include('components.stat-card', [
            'title' => 'Total Variabel',
            'value' => $variableStats['total'],
            'subtitle' => 'Variabel AKHLAK aktif',
            'tone' => 'yellow',
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3 9 5-9 5-9-5 9-5Z"></path><path d="m3 13 9 5 9-5"></path><path d="m3 17 9 5 9-5"></path></svg>',
        ])
        @include('components.stat-card', [
            'title' => 'Total Indikator',
            'value' => $variableStats['totalIndicators'],
            'subtitle' => 'Terhubung ke seluruh variabel',
            'tone' => 'blue',
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path><path d="M7 4v16"></path><path d="M17 4v16"></path></svg>',
        ])
        @include('components.stat-card', [
            'title' => 'Rata-rata Indikator',
            'value' => $variableStats['averageIndicators'],
            'subtitle' => 'Per variabel AKHLAK',
            'tone' => 'teal',
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19h16"></path><path d="M7 16V8"></path><path d="M12 16V5"></path><path d="M17 16v-4"></path></svg>',
        ])
        @include('components.stat-card', [
            'title' => 'Status',
            'value' => $variableStats['total'] > 0 ? 'Siap' : 'Kosong',
            'subtitle' => 'Master data variabel',
            'tone' => 'green',
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9 12 2 2 4-4"></path><path d="M20 12a8 8 0 1 1-4-6.92"></path></svg>',
        ])
    </section>

    <section class="content-grid content-grid-wide management-grid">
        <div class="dashboard-card card management-form-card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">{{ $editingVariable ? 'Edit Variabel' : 'Tambah Variabel' }}</span>
                    <h3>{{ $editingVariable ? 'Perbarui variabel AKHLAK' : 'Tambah variabel AKHLAK baru' }}</h3>
                </div>
                @if($editingVariable)
                    <a href="{{ route('kelola.variabel') }}" class="btn btn-outline-secondary">Batal</a>
                @endif
            </div>
            <form class="management-form" method="POST" action="{{ $editingVariable ? route('kelola.variabel.update', $editingVariable->id_variabel) : route('kelola.variabel.store') }}">
                @csrf
                @if($editingVariable)
                    @method('PUT')
                @endif

                <div class="form-field">
                    <label class="form-label" for="nama_variabel">Nama variabel</label>
                    <input
                        id="nama_variabel"
                        name="nama_variabel"
                        type="text"
                        class="form-control @error('nama_variabel') is-invalid @enderror"
                        value="{{ old('nama_variabel', $editingVariable->nama_variabel ?? '') }}"
                        placeholder="Contoh: Amanah"
                    >
                    @error('nama_variabel')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="assessment-note">
                    Pastikan variabel masih diperlukan sebelum dihapus. Jika variabel dihapus, semua indikator yang ada di dalamnya juga akan ikut terhapus.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-apes {{ $editingVariable ? '' : 'btn-with-icon' }}">
                        @if(!$editingVariable)
                            <span class="material-symbols-rounded">add</span>
                        @endif
                        <span>{{ $editingVariable ? 'Simpan Perubahan' : 'Tambah Variabel' }}</span>
                    </button>
                    <a href="{{ route('kelola.indikator') }}" class="btn btn-outline-secondary">Kelola Indikator</a>
                </div>
            </form>
        </div>

        <div class="dashboard-card card">
            <div class="dashboard-card-head">
                <div>
                    <span class="section-pill">AKHLAK Variables</span>
                    <h3>Kelola variabel AKHLAK</h3>
                </div>
            </div>
            <div class="management-card-grid">
                @forelse($variables as $variable)
                    <article class="management-card">
                        <div class="management-card-head">
                            <div class="management-card-icon">
                                <span class="material-symbols-rounded">{{ $variableIcons[$variable->nama_variabel] ?? 'category' }}</span>
                            </div>
                            @include('components.table-actions', [
                                'edit' => route('kelola.variabel', ['edit' => $variable->id_variabel]),
                                'delete' => route('kelola.variabel.destroy', $variable->id_variabel),
                            ])
                        </div>
                        <div class="management-card-copy">
                            <strong>{{ $variable->nama_variabel }}</strong>
                            <span>{{ $variable->indikator_count }} indikator aktif</span>
                        </div>
                        <div class="management-card-meta">
                            <span>Diperbarui</span>
                            <strong class="management-card-date">{{ optional($variable->updated_at)->format('d M Y') ?? '-' }}</strong>
                        </div>
                    </article>
                @empty
                    <div class="management-empty">
                        Belum ada variabel AKHLAK. Tambahkan variabel pertama untuk mulai menyusun indikator penilaian.
                    </div>
                @endforelse
            </div>
            <div class="pagination-note">
                <span>Menampilkan {{ $variables->count() }} dari {{ $variables->total() }} variabel</span>
                {{ $variables->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
</div>
@endsection
