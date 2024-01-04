@extends('layouts.app')

@section('title', 'Edit Riwayat Audit')

@section('styles')
	<!-- Google Font: Source Sans Pro -->
	<link
			rel="stylesheet"
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
	<link
			rel="stylesheet"
			href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
@endsection

@section('content-header')
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col">
				<ol class="text-sm breadcrumb float-sm-right">
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.riwayat-audit.indexUnitKerja') }}">
							Daftar Unit Kerja
						</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.riwayat-audit.index', [$unitKerja->id]) }}">
							{{ $unitKerja->nama }}
						</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}">
							Daftar Rencana Audit
						</a>
					</li>
					<li class="text-sm breadcrumb-item active">Edit Riwayat Rencana Audit</li>
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Rencana Audit Unit</h1>
			</div>
		</div>
	</div>
@endsection

@section('main-content')
	<div class="container-fluid">
		<div class="row">
			<section class="col col-sm-10 col-md-8 col-lg-6">
				<form
						action="{{ route('admin.riwayat-audit.update', [$unitKerja->id, $riwayatAudit->id]) }}"
						method="post">
					@csrf
					@method('PUT')
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

					<div class="form-group">
						<h2 class="text-lg p-0 m-0">Data Untuk Dokumen Cetak</h2>
						<small class="block text-muted">Data dibawah ini digunakan untuk mengisi data pada tampilan cetak dokumen</small>
					</div>

					<div class="form-group">
						<label class="col-form-label" for="nomor_dokumen">Nomor Dokumen</label>
						<input
								type="text" id="nomor_dokumen" name="nomor_dokumen"
								class="form-control @error('nomor_dokumen') is-invalid @enderror"
								value="{{ old('nomor_dokumen', $riwayatAudit->nomor_dokumen) }}"
								placeholder="Tuliskan disini..."/>
						@error('nomor_dokumen')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="status_revisi">Status Revisi</label>
						<input
								type="text" id="status_revisi" name="status_revisi"
								class="form-control @error('status_revisi') is-invalid @enderror"
								value="{{ old('status_revisi', $riwayatAudit->status_revisi) }}"
								placeholder="Tuliskan disini..."/>
						@error('status_revisi')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="tanggal_pembuatan">Tanggal Pembuatan</label>
						<div class="input-group date" id="tanggal_pembuatan_date_picker" data-target-input="nearest">
							<input type="text" name="tanggal_pembuatan" id="tanggal_pembuatan"
							       class="form-control datetimepicker-input @error('tanggal_pembuatan') is-invalid @enderror"
							       data-target="#tanggal_pembuatan_date_picker"
							       placeholder="Pilih..."
							       autocomplete="off"
							/>
							<div class="input-group-append"
							     data-target="#tanggal_pembuatan_date_picker"
							     data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
						@error('tanggal_pembuatan')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="halaman">Halaman</label>
						<input
								type="text" id="halaman" name="halaman"
								class="form-control @error('halaman') is-invalid @enderror"
								value="{{ old('halaman', $riwayatAudit->halaman) }}"
								placeholder="Tuliskan disini..."/>
						@error('halaman')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="ketua_tim_auditor">Ketua Tim Auditor</label>
						<input
								type="text" id="ketua_tim_auditor" name="ketua_tim_auditor"
								class="form-control @error('ketua_tim_auditor') is-invalid @enderror"
								value="{{ old('ketua_tim_auditor', $riwayatAudit->ketua_tim_auditor) }}"
								placeholder="Tuliskan disini..."/>
						@error('ketua_tim_auditor')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="kaur_sai">Kaur SAI</label>
						<input
								type="text" id="kaur_sai" name="kaur_sai"
								class="form-control @error('kaur_sai') is-invalid @enderror"
								value="{{ old('kaur_sai', $riwayatAudit->kaur_sai) }}"
								placeholder="Tuliskan disini..."/>
						@error('kaur_sai')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="kabag_sekpim_legal_audit">Kabag Sekpin, Legal dan Internal Audit</label>
						<input
								type="text" id="kabag_sekpim_legal_audit" name="kabag_sekpim_legal_audit"
								class="form-control @error('kabag_sekpim_legal_audit') is-invalid @enderror"
								value="{{ old('kabag_sekpim_legal_audit', $riwayatAudit->kabag_sekpim_legal_audit) }}"
								placeholder="Tuliskan disini..."/>
						@error('kabag_sekpim_legal_audit')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<hr>
					</div>

					<div class="form-group">
						<h2 class="text-lg p-0 m-0">Data Riwayat Audit</h2>
						<small class="block text-muted">Data dibawah ini digunakan sebagai pembeda riwayat dari rencana audit, checklist audit, dsb.</small>
					</div>

					<div class="form-group">
						@if (old('auditors'))
							@php $listOfAuditors = collect(old('auditors'))->map( fn($item) => ['id' => (int)$item]) @endphp
						@else
							@php $listOfAuditors = $riwayatAudit->auditors @endphp
						@endif
						<label class="col-form-label" for="auditors">Tim Auditor</label>
						<div class="select2-blue">
							<select
									id="auditors" name="auditors[]" multiple="multiple"
									class="form-control select2 @error('auditors') is-invalid @enderror"
									data-placeholder="Pilih..." data-dropdown-css-class="select2-blue"
									style="width: 100%;">
								@foreach($auditors as $auditor)
									<option
											{{ $listOfAuditors->filter(fn ($currentAuditor) => $currentAuditor['id'] === $auditor['id'])->count() ? 'selected' : '' }}
											value="{{ $auditor->id }}">
										{{ $auditor->name }}
									</option>
								@endforeach
							</select>
						</div>
						@error('auditors')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="auditee_id">Ketua Auditee</label>
						<select
								id="auditee_id" name="auditee_id"
								class="form-control select2bs4 @error('auditee_id') is-invalid @enderror"
								data-placeholder="Pilih...">
							<option selected disabled="disabled" value="">Pilih...</option>
							@foreach($auditees as $auditee)
								<option
										{{ (int)old('auditee_id', $riwayatAudit->auditee_id) == $auditee->id ? 'selected' : '' }}
										value="{{ $auditee->id }}">
									{{ $auditee->name }}
								</option>
							@endforeach
						</select>
						@error('auditee_id')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="tanggal_rencana">Tanggal Perencanaan</label>
						<div class="input-group date" id="tanggal_rencana_date_picker" data-target-input="nearest">
							<input type="text" name="tanggal_rencana" id="tanggal_rencana"
							       class="form-control datetimepicker-input @error('tanggal_rencana') is-invalid @enderror"
							       data-target="#tanggal_rencana_date_picker"
							       placeholder="Pilih..."
							       autocomplete="off"
							/>
							<div class="input-group-append"
							     data-target="#tanggal_rencana_date_picker"
							     data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
						@error('tanggal_rencana')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="lokasi">Lokasi</label>
						<input
								type="text" id="lokasi" name="lokasi"
								class="form-control @error('lokasi') is-invalid @enderror"
								value="{{ old('lokasi', $riwayatAudit->lokasi) }}"
								placeholder="Tuliskan disini..."/>
						@error('lokasi')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="ruang_lingkup_id">Ruang Lingkup</label>
						<select
								id="ruang_lingkup_id" name="ruang_lingkup_id"
								class="form-control select2bs4 @error('ruang_lingkup_id') is-invalid @enderror"
								data-placeholder="Pilih...">
							<option selected disabled="disabled" value="">Pilih...</option>
							@foreach($ruangLingkups as $ruangLingkup)
								<option
										{{ (int)old('ruang_lingkup_id', $riwayatAudit->ruang_lingkup_id) == $ruangLingkup->id ? 'selected' : '' }}
										value="{{ $ruangLingkup->id }}">
									{{ $ruangLingkup->getRuangLingkupFormat() }}
								</option>
							@endforeach
						</select>
						@error('ruang_lingkup_id')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
						<a href="{{ route('admin.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}#rencana-audits"
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

          //Date picker
          const currentPembuatanTanggal = moment("{{ old('tanggal_pembuatan', $riwayatAudit->tanggal_pembuatan) }}");
          $('#tanggal_pembuatan_date_picker').datetimepicker({
              defaultDate: currentPembuatanTanggal,
              locale: 'id',
              format: 'L',
          });

          const currentRencanaTanggal = moment("{{ old('tanggal_rencana', $riwayatAudit->tanggal_rencana) }}");
          $('#tanggal_rencana_date_picker').datetimepicker({
              defaultDate: currentRencanaTanggal,
              locale: 'id',
              format: 'L',
          });
      });
	</script>
@endsection
