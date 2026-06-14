@extends('layouts.app')

@section('title','Tambah Karyawan')
@section('page_title','Tambah Karyawan')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">Employee Form</span>
                <h3>Tambah data karyawan</h3>
            </div>
        </div>
        <div class="p-4">
            @include('employees._form', [
                'employee' => $employee,
                'formAction' => $formAction,
                'formMethod' => $formMethod,
                'submitLabel' => 'Simpan Karyawan',
                'cancelRoute' => route('kelola.karyawan'),
            ])
        </div>
    </section>
</div>
@endsection
