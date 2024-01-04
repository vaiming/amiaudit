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
						<a href="{{ route('auditor.checklist-audit.indexUnitKerja') }}">
              {{ __('Beranda') }}
            </a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('auditor.checklist-audit.riwayat-audit.index', [$unitKerja->id]) }}">
              Daftar Riwayat Checklist Audit - {{ $unitKerja->nama }}
						</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('auditor.checklist-audit.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}">
							Daftar Checklist Audit
						</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('auditor.checklist-audit.show', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}#detail-checklist-audit">
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
				<form action="{{ route('auditor.checklist-audit.langkah-kerja.store', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}" method="POST">
					@csrf
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
						<div>
							<span class="text-bold">Auditor</span>
							<p>{{ $checklistAudit->auditor->name ?? 'Tidak ada'}}</p>
						</div>
						<div>
							<span class="text-bold">Auditee</span>
							<p>{{ $checklistAudit->auditee->name ?? 'Tidak ada'}}</p>
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
						<label class="col-form-label" for="number_langkah_kerja">Langkah Kerja</label>
						<div class="input-group mb-3">
							<input type="number" name="number_langkah_kerja" value="{{ old('number_langkah_kerja') }}"
							       id="number_langkah_kerja_input" class="form-control @error('number_langkah_kerja') is-invalid @enderror"
							       placeholder="Masukkan jumlah langkah kerja..."
							       autocomplete="off"
							>
							<div class="input-group-append">
								<input type="button" value="Tambah"
								       id="number_langkah_kerja_btn"
								       class="btn btn-primary"/>
							</div>
						</div>

						<div class="langkah_kerja_container"></div>

						@error('number_langkah_kerja')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
						<a href="{{ route('auditor.checklist-audit.show', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id,]) }}#detail-checklist-audit"
						   class="btn btn-danger text-uppercase">
							Batal
						</a>
						<button class="btn btn-primary text-uppercase" type="submit">Submit</button>
					</div>
				</form>
			</section>
		</div>
	</div>
@endsection

@section('sidebar')
	@include('auditor.sidebar')
@endsection

@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

	<!-- Page specific script -->
	<script>
      $(document).ready(function () {
          const measureInputContainer = $('#langkah_kerja_form .langkah_kerja_container');
          measureInputContainer.prev().children().last().click(function ($event) {
              if (measureInputContainer.children().length > 0) {
                  measureInputContainer.children().remove();
              }

              let template = '';
              for (let i = 0; i < measureInputContainer.prev().children().first().val(); i++) {
                  template += `
                    <div class="form-group">
											<textarea class="form-control" rows="3" name="langkah_kerja_${i + 1}"
																placeholder="Masukkan langkah kerja ke-${i + 1}..."
											></textarea>
										</div>
                  `
              }
              measureInputContainer.html(template);
          });
      });
	</script>
@endsection
