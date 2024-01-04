@extends('layouts.app')

@section('title', 'Tambah Checklist Audit Unit')

@section('styles')
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
	      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
@endsection

@section('content-header')
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col">
				<ol class="text-sm breadcrumb float-sm-right">
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.checklist-audit.indexUnitKerja') }}">
              {{ __('Beranda') }}
            </a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.checklist-audit.riwayat-audit.index', [$unitKerja->id]) }}">
              Daftar Riwayat Checklist Audit - {{ $unitKerja->nama }}
						</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.checklist-audit.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}">
							Daftar Checklist Audit
						</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.checklist-audit.show', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}#detail-checklist-audit">
							Detail Checklist Audit
						</a>
					</li>
					<li class="text-sm breadcrumb-item active">Tambah Langkah Kerja Checklist Audit</li>
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Checklist Audit Unit</h1>
			</div>
		</div>
	</div>
@endsection

@section('main-content')
	<div class="container-fluid">
		<div class="row">
			<section class="col-xl-6 col-md-8 col-sm-10 col-12">
				@if($errors->any())
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<h6>Pesan Error:</h6>
						<ul class="mb-0 pl-4">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif

				<div class="d-flex flex-column">
					<div class="row">
						<div class="col col-12 col-sm-6">
							<span class="text-bold">Auditor</span>
							<p>{{ $checklistAudit->auditor->name ?? 'Tidak ada'}}</p>
						</div>
						<div class="col col-12 col-sm-6">
							<span class="text-bold">Auditee</span>
							<p>{{ $checklistAudit->auditee->name ?? 'Tidak ada'}}</p>
						</div>
					</div>
					<div>
						<span class="text-bold">Standar Kriteria</span>
						<p>{{ $checklistAudit->standarKriteria->nama ?? 'Tidak ada' }}</p>
					</div>
					<div>
						<span class="text-bold">Indikator</span>
						<p>{{ $checklistAudit->indikator->indikator ?? 'Tidak ada' }}</p>
					</div>
					<div>
						<span class="text-bold">Measure</span>
						<p>{{ $checklistAudit->measure->measure ?? 'Tidak ada'}}</p>
					</div>
				</div>

				<div class="form-group" id="langkah_kerja_form">
					<label class="col-form-label">Langkah Kerja</label>

					<div class="langkah_kerja_container">
            <ul class="pl-4">
              @foreach ($checklistAudit->langkah_kerja_checklists as $item)
                <li>
                  <div class="form-group">
                    <form id="langkah_kerja_form_update_{{$item->id}}" method="POST"
                          action="{{ route('admin.checklist-audit.langkah-kerja.update', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $item->id]) }}">
                      @csrf
                      @method('PUT')
                      <label for="langkah_kerja_{{$item->id}}" class="col-form-label">Langkah Kerja
                        Ke-{{$loop->iteration}}</label>
                      <textarea name="langkah_kerja_{{$item->id}}" id="langkah_kerja_{{$item->id}}"
                                placeholder="Masukkan langkah kerja ke-{{$loop->iteration}}..."
                                rows="3" class="form-control"
                      >{{$item->langkah_kerja}}</textarea>

                      @error('langkah_kerja_'.$item->id)
                      <div class="invalid-feedback text-danger d-block">
                        {{ $message }}
                      </div>
                      @enderror
                    </form>

                    <div class="mt-2 d-flex justify-content-end align-items-center" style="gap: .5rem">
                      <a class="btn btn-outline-warning btn-sm"
                         href="{{ route('admin.checklist-audit.langkah-kerja.update', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $item->id]) }}"
                         onclick="event.preventDefault();document.getElementById('langkah_kerja_form_update_{{$item->id}}').submit()"
                      ><i class="mr-2 fas fa-pen"></i>Update</a>
                      <form id="langkah_kerja_form_delete_{{$item->id}}" method="POST"
                            action="{{ route('admin.checklist-audit.langkah-kerja.destroy', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $item->id]) }}">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-outline-danger btn-sm" type="submit">
                          <i class="mr-2 fas fa-trash"></i>Delete
                        </button>
                      </form>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
					</div>
				</div>

				<div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
					<a href="{{ route('admin.checklist-audit.show', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id,]) }}#detail-checklist-audit"
					   class="btn btn-default text-capitalize">
						<i class="mr-2 fas fa-reply"></i>Kembali
					</a>
				</div>
			</section>
		</div>
	</div>
@endsection

@section('sidebar')
	@include('admin.sidebar')
@endsection

@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
@endsection
