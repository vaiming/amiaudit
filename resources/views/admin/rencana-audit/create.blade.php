@extends('layouts.app')

@section('title', 'Tambah Rencana Audit Unit')

@section('styles')
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link
			rel="stylesheet"
			href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
@endsection

@section('content-header')
	<div class="container-fluid">
		<div class="row mb-2">
			<!-- /.col -->
			<div class="col">
				<ol class="text-sm breadcrumb float-sm-right">
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.rencana-audit.indexUnitKerja') }}">Beranda</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.rencana-audit.riwayat-audit.index', [$unitKerja->id]) }}">
              Daftar Riwayat Rencana Audit - {{ $unitKerja->nama }}
						</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.rencana-audit.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}">
							Daftar Rencana Audit
						</a>
					</li>
					<li class="text-sm breadcrumb-item active">Tambah Rencana Audit</li>
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Rencana Audit Unit</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endsection

@section('main-content')
	<div class="container-fluid">
		<!-- Main row -->
		<div class="row">
			<!-- Left col -->
			<section class="col col-sm-10 col-md-8 col-lg-6">
				<!-- Default box -->
				<form action="{{ route('admin.rencana-audit.store', [$unitKerja->id, $riwayatAudit->id]) }}" method="POST">
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

					<div class="row">
						<div class="col col-12 col-sm-6">
							<div class="form-group">
								<label class="col-form-label" for="auditor">Auditor</label>
								<select
										id="auditor" name="auditor"
										class="form-control select2bs4 @error('auditor') is-invalid @enderror"
										data-placeholder="Pilih auditor">
									<option selected disabled="disabled" value="">Pilih...</option>
									@foreach($auditors as $auditor)
										<option
												{{ (int)old('auditor') === $auditor->id ? 'selected' : '' }}
												value="{{ $auditor->id }}">
											{{ $auditor->name }}
										</option>
									@endforeach
								</select>
								@error('auditor')
								<div class="invalid-feedback text-danger d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col col-12 col-sm-6">
							<div class="form-group">
								<label class="col-form-label" for="auditee">Auditee</label>
								<select
										id="auditee" name="auditee"
										class="form-control select2bs4 @error('auditee') is-invalid @enderror"
										data-placeholder="Pilih auditee">
									<option selected disabled="disabled" value="">Pilih...</option>
									@foreach($auditees as $auditee)
										<option
												{{ (int)old('auditee') === $auditee->id ? 'selected' : '' }}
												value="{{ $auditee->id }}">
											{{ $auditee->name }}
										</option>
									@endforeach
								</select>
								@error('auditee')
								<div class="invalid-feedback text-danger d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-form-label" for="sub_unit_kerja">Sub Unit Kerja</label>
						<input
								type="text" id="sub_unit_kerja" name="sub_unit_kerja"
								class="form-control @error('sub_unit_kerja') is-invalid @enderror"
								value="{{ old('sub_unit_kerja') }}"
								placeholder="Sub Unit Kerja"/>
						@error('sub_unit_kerja')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="dokumen">Dokumen</label>
						<input
								type="text" id="dokumen" name="dokumen"
								class="form-control @error('dokumen') is-invalid @enderror"
								value="{{ old('dokumen') }}"
								placeholder="Dokumen"/>
						@error('dokumen')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="standar_kriteria">Standar Kriteria</label>
						<select
								id="standar_kriteria" name="standar_kriteria"
								class="form-control select2bs4 @error('standar_kriteria') is-invalid @enderror"
								data-placeholder="Pilih standar kriteria">
							<option selected disabled="disabled" value="">Pilih...</option>
							@foreach($standarKriterias as $standarKriteria)
								<option
										{{ old('standar_kriteria') == $standarKriteria->id ? 'selected' : '' }}
										value="{{ $standarKriteria->id }}">
									{{ $standarKriteria->nama }}
								</option>
							@endforeach
						</select>
						@error('standar_kriteria')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
						<a href="{{ route('admin.rencana-audit.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}#rencana-audits"
						   class="btn btn-danger text-uppercase"
						>Batal</a>
						<button class="btn btn-primary text-uppercase" type="submit">Submit</button>
					</div>
				</form>
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
	<!-- Select2 -->
	<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- Moment -->
	<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

	<!-- Page specific script -->
	<script>
      $(document).ready(function () {
          $('.select2').select2()

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          });
      });
	</script>
@endsection
