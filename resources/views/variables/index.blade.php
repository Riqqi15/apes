@extends('layouts.app')

@section('title','Kelola Variabel')
@section('page_title','Kelola Variabel')

@section('content')
<div class="dashboard-grid">
    <section class="dashboard-card card">
        <div class="dashboard-card-head">
            <div>
                <span class="section-pill">AKHLAK Variables</span>
                <h3>Kelola variabel AKHLAK</h3>
            </div>
            <a href="#" class="btn btn-apes">Tambah Variabel</a>
        </div>
        <div class="variable-grid">
            @foreach(['Amanah','Kompeten','Harmonis','Loyal','Adaptif','Kolaboratif'] as $variable)
                <div class="variable-pill">
                    <strong>{{ $variable }}</strong>
                    <span>6 indikator aktif</span>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
