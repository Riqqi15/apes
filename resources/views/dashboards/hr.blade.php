@extends('layouts.app')

@section('title','Dashboard HR')
@section('page_title','Dashboard HR')

@section('content')
<div class="row g-3">
  <div class="col-md-3">@include('components.stat-card',['title'=>'Total Karyawan','value'=>'—'])</div>
  <div class="col-md-3">@include('components.stat-card',['title'=>'Total Variabel','value'=>'—'])</div>
  <div class="col-md-3">@include('components.stat-card',['title'=>'Indikator','value'=>'—'])</div>
  <div class="col-md-3">@include('components.stat-card',['title'=>'Penilaian Selesai','value'=>'—'])</div>
</div>
<div class="mt-4 card"><div class="card-body">Dashboard HR placeholder</div></div>
@endsection
