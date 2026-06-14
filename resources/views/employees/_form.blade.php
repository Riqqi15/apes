@php
    $employee = $employee ?? [];
    $formAction = $formAction ?? '#';
    $formMethod = strtoupper($formMethod ?? 'POST');
    $submitLabel = $submitLabel ?? 'Simpan';
    $cancelRoute = $cancelRoute ?? null;
    $cancelLabel = $cancelLabel ?? 'Batal';
@endphp

<form method="POST" action="{{ $formAction }}">
    @csrf
    @if($formMethod !== 'POST')
        @method($formMethod)
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input class="form-control" name="nama_lengkap" type="text" value="{{ old('nama_lengkap', $employee->nama_lengkap ?? '') }}" placeholder="Nama lengkap">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">NIP</label>
            <input class="form-control" name="nip" type="text" value="{{ old('nip', $employee->nip ?? '') }}" placeholder="EMP-0000">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Departemen</label>
            <input class="form-control" name="departemen" type="text" value="{{ old('departemen', $employee->departemen ?? '') }}" placeholder="Finance">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Jabatan / Posisi</label>
            <input class="form-control" name="jabatan" type="text" value="{{ old('jabatan', $employee->jabatan ?? '') }}" placeholder="Senior Analyst">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">No. HP</label>
            <input class="form-control" name="no_hp" type="text" value="{{ old('no_hp', $employee->no_hp ?? '') }}" placeholder="0812xxxx">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Tanggal Lahir</label>
            <input class="form-control" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir', isset($employee->tanggal_lahir) ? optional($employee->tanggal_lahir)->format('Y-m-d') : '') }}">
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat lengkap">{{ old('alamat', $employee->alamat ?? '') }}</textarea>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-apes" type="submit">{{ $submitLabel }}</button>
        @if($cancelRoute)
            <a href="{{ $cancelRoute }}" class="btn btn-outline-secondary">{{ $cancelLabel }}</a>
        @endif
    </div>
</form>
