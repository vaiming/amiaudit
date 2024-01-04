<div class="card">
	<div class="card-header">
		<h3 class="card-title" id="tambah-measure-pernyataan-uk">Tambah Measure Unit Kerja</h3>

		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="maximize">
				<i class="fas fa-expand"></i>
			</button>
			<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
			</button>
			<button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<form action="{{ route('admin.dashboard.unit-kerja.standar-kriteria.pernyataan.measure.attach', [$unitKerja->id, $standarKriteria->id, $pernyataanStandar->id]) }}" method="POST">
			@csrf
			@if($errors->attach_measure_uk->any())
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<h6>Pesan Error:</h6>
					<ul class="mb-0 pl-4">
						@foreach ($errors->attach_measure_uk->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif

			<div class="form-group">
				<label>Unit Kerja</label>
				<input type="text" class="form-control"
				       placeholder="{{ $unitKerja->nama }}" disabled>
			</div>

			<div class="form-group">
				<label>Standar Kriteria</label>
				<input type="text" class="form-control"
				       placeholder="{{ $standarKriteria->nama }}" disabled>
			</div>

			<div class="form-group">
				<label>Pernyataan Standar</label>
				<textarea class="form-control" rows="5" disabled>{{$pernyataanStandar->pernyataan_standar}}</textarea>
			</div>

			<div class="form-group">
				<label class="col-form-label" for="measure">Measure Pernyataan</label>
				<div class="select2-blue">
					<select id="measure" name="measure[]" multiple="multiple"
                  class="form-control select2 @error('measure', 'attach_measure_uk') is-invalid @enderror"
                  data-placeholder="Pilih measure..." data-dropdown-css-class="select2-blue"
                  style="width: 100%;">
						@foreach ($measures as $item)
							<option value="{{ $item->id }}">{{ $item->measure }}</option>
						@endforeach
					</select>
				</div>
				@error('measure', 'attach_measure_uk')
				<div class="invalid-feedback text-danger d-block">
					{{ $message }}
				</div>
				@enderror
			</div>

			<div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
				<a href="{{ route('admin.dashboard') }}" class="btn btn-danger text-uppercase"
				>Batal</a>
				<button class="btn btn-primary text-uppercase" type="submit">Submit</button>
			</div>
		</form>

	</div>
</div>
