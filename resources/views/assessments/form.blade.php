@extends('layouts.app')

@section('title','Melakukan Penilaian')
@section('page_title','Melakukan Penilaian')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Step 1</span>
                <h3>Pilih periode, karyawan, dan mulai penilaian</h3>
            </div>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label fw-semibold">Periode</label><select class="form-select">@forelse($periods as $period)<option value="{{ $period->id_periode }}">{{ $period->nama_periode }}</option>@empty<option value="">Belum ada periode</option>@endforelse</select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Karyawan</label><select class="form-select">@forelse($employees as $employee)<option value="{{ $employee->id_karyawan }}">{{ $employee->nama_lengkap }}</option>@empty<option value="">Belum ada karyawan</option>@endforelse</select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Role</label><select class="form-select">@forelse($roleTypes as $role)<option value="{{ $role }}">{{ $role }}</option>@empty<option value="">Belum ada role</option>@endforelse</select></div>
            </div>
        </div>
    </section>

    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Step 2</span>
                <h3>Skor per indikator</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr><th>Variable</th><th>Indikator</th><th>Skor</th></tr>
                </thead>
                <tbody>
                    @forelse($indicators as $indicator)
                        <tr>
                            <td>{{ $indicator->variabel?->nama_variabel }}</td>
                            <td>{{ $indicator->nama_indikator }}</td>
                            <td>1 - 5</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-secondary py-4">Belum ada indikator aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
