@extends('layouts.app')

@section('title', 'Tambah Checklist Audit Unit')

@section('styles')
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
	      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Select2 -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
					<li class="text-sm breadcrumb-item active">Tambah Checklist Audit</li>
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
				<form action="{{ route('auditor.checklist-audit.store', [$unitKerja->id, $riwayatAudit->id]) }}" method="POST">
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
										data-placeholder="Pilih...">
									<option selected value="-1">Pilih...</option>
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
										data-placeholder="Pilih...">
									<option selected value="-1">Pilih...</option>
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
						<label class="col-form-label" for="standar_kriteria">Standar Kriteria</label>
						<select
								id="standar_kriteria" name="standar_kriteria"
								class="form-control select2bs4 @error('standar_kriteria') is-invalid @enderror"
								data-placeholder="Pilih...">
							@if ($standarKriterias->isNotEmpty())
								<option selected value="-1">Pilih...</option>
								@foreach($standarKriterias as $standarKriteria)
									<option value="{{ $standarKriteria->id }}">
										{{ $standarKriteria->nama }}
									</option>
								@endforeach
							@endif
						</select>
						@error('standar_kriteria')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="pernyataan_standar">Pernyataan Standar</label>
						<select
								id="pernyataan_standar" name="pernyataan_standar"
								class="form-control select2bs4 @error('pernyataan_standar') is-invalid @enderror"
								data-placeholder="Pilih...">
						</select>
						@error('pernyataan_standar')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="indikator">Indikator</label>
						<select
								id="indikator" name="indikator"
								class="form-control select2bs4 @error('indikator') is-invalid @enderror"
								data-placeholder="Pilih...">
						</select>
						@error('indikator')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="measure">Measure</label>
						<select
								id="measure" name="measure"
								class="form-control select2bs4 @error('measure') is-invalid @enderror"
								data-placeholder="Pilih...">
						</select>
						@error('measure')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="tentatif_audit_objektif">Tentatif Audit Objektif/Resiko</label>
						<textarea
								id="tentatif_audit_objektif" name="tentatif_audit_objektif" rows="3" style="width: 100%"
								class="form-control @error('tentatif_audit_objektif') is-invalid @enderror"
								placeholder="Tuliskan disini..."
						>{{ old('tentatif_audit_objektif') }}</textarea>
						@error('tentatif_audit_objektif')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="tujuan">Tujuan Audit</label>
						<textarea
								id="tujuan" name="tujuan" rows="3" style="width: 100%"
								class="form-control @error('tujuan') is-invalid @enderror"
								placeholder="Tuliskan disini..."
						>{{ old('tujuan') }}</textarea>
						@error('tujuan')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
						<a href="{{ route('auditor.checklist-audit.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}#checklist-audits"
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
	<!-- Select2 -->
	<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

	<!-- Page specific script -->
	<script>
      $(document).ready(function () {
          $('.select2').select2();

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          });

          let standarKriteriaId = null;
          $('select#standar_kriteria').change(function ($event) {
              standarKriteriaId = parseInt($event.target.value) > 0 ? parseInt($event.target.value) : null;
              console.log(standarKriteriaId);

              if (standarKriteriaId) {
                  fetch(`/auditor/unit-kerja/{{$unitKerja->id}}/riwayat-checklist-audit/{{$riwayatAudit->id}}/checklist-audit/standar-kriteria/${standarKriteriaId}/pernyataan`)
                      .then(response => response.json())
                      .then(response => {
                          let items = '';
                          if (response.data.pernyataan_standars.length > 0) {
                              items = '<option selected value="-1">Pilih...</option>';
                              response.data.pernyataan_standars.forEach(function (data, i) {
                                  items += `<option value="${data.id}">${data.pernyataan_standar}</option>`;
                              });
                          }
                          $('select#indikator').empty();
                          $('select#measure').empty();
                          $('select#pernyataan_standar').html(items);
                      })
                      .catch(error => {
                          console.error(error);
                      });
              } else {
                  $('select#pernyataan_standar').empty();
                  $('select#indikator').empty();
                  $('select#measure').empty();
              }
          });

          let pernyataanId = null
          $('select#pernyataan_standar').change(function ($event) {
              pernyataanId = parseInt($event.target.value) > 0 ? parseInt($event.target.value) : null;
              console.log($event.target.value);

              if (pernyataanId) {
                  fetch(`/auditor/unit-kerja/{{$unitKerja->id}}/riwayat-checklist-audit/{{$riwayatAudit->id}}/checklist-audit/standar-kriteria/${standarKriteriaId}/pernyataan/${pernyataanId}/indikator-&-measure`)
                      .then(response => response.json())
                      .then(response => {
                          let indikators = '';
                          if (response.data.indikators.length > 0) {
                              indikators = '<option selected value="-1">Pilih...</option>';
                              response.data.indikators.forEach(function (data, i) {
                                  indikators += `<option value="${data.id}">${data.indikator}</option>`;
                              });
                          }
                          $('select#indikator').html(indikators);

                          let measures = '';
                          if (response.data.measures.length > 0) {
                              measures = '<option selected value="-1">Pilih...</option>';
                              response.data.measures.forEach(function (data, i) {
                                  measures += `<option value="${data.id}">${data.measure}</option>`;
                              });
                          }
                          $('select#measure').html(measures);
                      })
                      .catch(error => {
                          console.error(error);
                      });
              } else {
                  $('select#indikator').empty();
                  $('select#measure').empty();
              }
          });
      });
	</script>
@endsection
