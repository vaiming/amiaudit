@extends('layouts.app')

@section('title', 'Tambah PTK Unit')

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
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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
						<a href="{{ route('admin.ptk.indexUnitKerja') }}">
              {{ __('Beranda') }}
            </a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.ptk.riwayat-audit.index', [$unitKerja->id]) }}">
              Daftar Riwayat PTK/OAI - {{ $unitKerja->nama }}
						</a>
					</li>
					<li class="text-sm breadcrumb-item">
						<a href="{{ route('admin.ptk.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}">
							Daftar PTK/OAI
						</a>
					</li>
					<li class="text-sm breadcrumb-item active">Tambah PTK</li>
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Tambah PTK Unit</h1>
			</div>
		</div>
	</div>
@endsection

@section('main-content')
	<div class="container-fluid">
		<div class="row">
			<section class="col-xl-6 col-md-8 col-sm-10 col-12">
				<form action="{{ route('admin.ptk.store', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}" method="POST">
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

					<div class="form-group">
						<label>Standar Kriteria</label>
						<input type="text" class="form-control"
						       placeholder="{{ $checklistAudit->standarKriteria->nama }}" disabled>
					</div>

					<div class="form-group">
						<label>Pernyataan Standar</label>
						<textarea class="form-control" rows="4" disabled>{{$checklistAudit->pernyataan_standar->pernyataan_standar}}</textarea>
					</div>

					<div class="form-group">
						<label>Indikator</label>
						<textarea class="form-control" rows="2" disabled>{{$checklistAudit->indikator->indikator}}</textarea>
					</div>

					<div class="form-group">
						<label>Measure</label>
						<textarea class="form-control" rows="2" disabled>{{$checklistAudit->measure->measure}}</textarea>
					</div>

					<div class="form-group">
						<label class="col-form-label" for="type">Tipe Temuan</label>
						<select
								id="type" name="type"
								class="form-control select2bs4 @error('type') is-invalid @enderror"
								data-placeholder="Pilih tipe...">
							<option selected disabled value="">Pilih...</option>
							<option
									{{ old('type') === 'ptk' ? 'selected' : '' }}
									value="ptk">
								PTK
							</option>
							<option
									{{ old('type') === 'oai' ? 'selected' : '' }}
									value="oai">
								OAI
							</option>
						</select>
						@error('type')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="pb-0 d-block col-form-label">Deskripsi Ketidaksesuaian</label>
						<small class="mb-2 d-inline-block text-muted">PLOR adalah singkatan dari Problem, Location, Objective dan Reference</small>

						<table class="mb-3" style="width: 100%">
							<tbody>
							<tr>
								<td style="vertical-align: top;">
									<label for="problem" class="col-form-label"
									>Problem</label>
								</td>
								<td>
									<textarea name="problem" id="problem" placeholder="Tuliskan disini..."
	                          class="form-control @error('problem') is-invalid @enderror"
									          rows="3"
									>{{old('problem')}}</textarea>

									@error('problem')
									<div class="invalid-feedback text-danger d-block">
										{{ $message }}
									</div>
									@enderror
								</td>
							</tr>
							<tr>
								<td style="vertical-align: top;">
									<label for="location" class="col-form-label"
									>Location</label>
								</td>
								<td>
									<textarea name="location" id="location" placeholder="Tuliskan disini..."
	                          class="form-control @error('location') is-invalid @enderror"
									          rows="3"
									>{{old('location')}}</textarea>

									@error('location')
									<div class="invalid-feedback text-danger d-block">
										{{ $message }}
									</div>
									@enderror
								</td>
							</tr>
							<tr>
								<td style="vertical-align: top;">
									<label for="objective" class="col-form-label"
									>Objective</label>
								</td>
								<td>
									<textarea name="objective" id="objective" placeholder="Tuliskan disini..."
	                          class="form-control @error('objective') is-invalid @enderror"
									          rows="3"
									>{{old('objective')}}</textarea>

									@error('objective')
									<div class="invalid-feedback text-danger d-block">
										{{ $message }}
									</div>
									@enderror
								</td>
							</tr>
							<tr>
								<td style="vertical-align: top;">
									<label for="reference" class="col-form-label"
									>Reference</label>
								</td>
								<td>
									<textarea name="reference" id="reference" placeholder="Tuliskan disini..."
	                          class="form-control @error('reference') is-invalid @enderror"
									          rows="3"
									>{{old('reference')}}</textarea>

									@error('reference')
									<div class="invalid-feedback text-danger d-block">
										{{ $message }}
									</div>
									@enderror
								</td>
							</tr>
							</tbody>
						</table>
					</div>

					<div class="form-group">
						<label class="col-form-label" for="analisa_akar_masalah">Analisa Akar Masalah</label>
						<textarea
								id="analisa_akar_masalah" name="analisa_akar_masalah" rows="3" style="width: 100%"
								class="form-control @error('analisa_akar_masalah') is-invalid @enderror"
								placeholder="Tuliskan disini..."
						>{{ old('analisa_akar_masalah') }}</textarea>
						@error('analisa_akar_masalah')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="akibat">Akibat</label>
						<textarea
								id="akibat" name="akibat" rows="3" style="width: 100%"
								class="form-control @error('akibat') is-invalid @enderror"
								placeholder="Tuliskan disini..."
						>{{ old('akibat') }}</textarea>
						@error('akibat')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="permintaan_tindakan_koreksi">Rekomendasi/Permintaan Tindakan
							Koreksi</label>
						<textarea
								id="permintaan_tindakan_koreksi" name="permintaan_tindakan_koreksi" rows="3" style="width: 100%"
								class="form-control @error('permintaan_tindakan_koreksi') is-invalid @enderror"
								placeholder="Tuliskan disini..."
						>{{ old('permintaan_tindakan_koreksi') }}</textarea>
						@error('permintaan_tindakan_koreksi')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="rencana_tindakan_perbaikan">Rencana Tindakan Perbaikan</label>
						<textarea
								id="rencana_tindakan_perbaikan" name="rencana_tindakan_perbaikan" rows="3" style="width: 100%"
								class="form-control @error('rencana_tindakan_perbaikan') is-invalid @enderror"
								placeholder="Tuliskan disini..."
						>{{ old('rencana_tindakan_perbaikan') }}</textarea>
						@error('rencana_tindakan_perbaikan')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="rencana_pencegahan">Rencana Pencegahan</label>
						<textarea
								id="rencana_pencegahan" name="rencana_pencegahan" rows="3" style="width: 100%"
								class="form-control @error('rencana_pencegahan') is-invalid @enderror"
								placeholder="Tuliskan disini..."
						>{{ old('rencana_pencegahan') }}</textarea>
						@error('rencana_pencegahan')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="penanggung_jawab_perbaikan">Penanggung Jawab Perbaikan</label>
						<select
								id="penanggung_jawab_perbaikan" name="penanggung_jawab_perbaikan"
								class="form-control select2bs4 @error('penanggung_jawab_perbaikan') is-invalid @enderror"
								data-placeholder="Pilih...">
							<option selected disabled value="">Pilih...</option>
							@foreach($unitKerjas as $item)
								<option
										{{ old('penanggung_jawab_perbaikan') === $item->id ? 'selected' : '' }}
										value="{{ $item->id }}">
									{{ $item->nama }}
								</option>
							@endforeach
						</select>
						@error('penanggung_jawab_perbaikan')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="form-group">
						<label class="col-form-label" for="repairing_datetime_finish">Batas Waktu Perbaikan</label>
						<div class="input-group date" id="repairing_datetime_finish_date_picker" data-target-input="nearest">
							<input type="text" name="repairing_datetime_finish" id="repairing_datetime_finish"
							       class="form-control datetimepicker-input @error('repairing_datetime_finish') is-invalid @enderror"
							       data-target="#repairing_datetime_finish_date_picker"
							       placeholder="Masukkan waktu perbaikan..."
							       autocomplete="off"
							/>
							<div class="input-group-append"
							     data-target="#repairing_datetime_finish_date_picker"
							     data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
						@error('repairing_datetime_finish')
						<div class="invalid-feedback text-danger d-block">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
						<a href="{{ route('admin.ptk.riwayat-audit.show', [$unitKerja->id, $riwayatAudit->id]) }}#history-ptk"
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
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- Select2 -->
	<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- Moment -->
	<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

	<!-- Page specific script -->
	<script>
      $(document).ready(function () {
          //Date picker
          $('#repairing_datetime_finish_date_picker').datetimepicker({
              locale: 'id',
              format: 'L',
              minDate: moment(),
          });

          $('.select2').select2();

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          });
      });
	</script>
@endsection
