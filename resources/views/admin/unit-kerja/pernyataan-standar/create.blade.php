<div class="card">
	<div class="card-header">
		<h3 class="card-title" id="tambah-pernyataan-uk">Tambah Pernyataan Unit Kerja</h3>

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
		<form action="{{ route('admin.dashboard.unit-kerja.indikator.store', [$unitKerja->id]) }}" method="POST">
			@csrf
			@if($errors->attach_pernyataan_uk->any())
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<h6>Pesan Error:</h6>
					<ul class="mb-0 pl-4">
						@foreach ($errors->attach_pernyataan_uk->all() as $error)
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

			<div class="form-group" id="standar-kriteria-uk">
				<label class="col-form-label" for="standar_kriteria">Standar Kriteria</label>
				<select
						id="standar_kriteria"
						name="standar_kriteria"
						class="form-control select2 select2-blue @error('standar_kriteria', 'attach_pernyataan_uk') is-invalid @enderror"
						data-placeholder="Pilih standar kriteria..."
						data-dropdown-css-class="select2-blue"
						style="width: 100%;"
						onchange="addPernyataanInput(event, '{{$unitKerja->id}}')">
					@foreach ($standarKriterias as $skk)
						<option value="{{ $skk->id }}">{{ $skk->nama }}</option>
					@endforeach
				</select>
				@error('standar_kriteria', 'attach_pernyataan_uk')
				<div class="invalid-feedback text-danger d-block">
					{{ $message }}
				</div>
				@enderror
			</div>

			<div class="form-group">
				<label class="col-form-label" for="pernyataan">Pernyataan Standar Kriteria</label>
				<div class="select2-blue">
					<select
							id="pernyataan"
							name="pernyataan[]"
							class="form-control select2 @error('pernyataan', 'attach_pernyataan_uk') is-invalid @enderror"
							multiple="multiple"
							data-placeholder="Pilih pernyataan standar kriteria..."
							data-dropdown-css-class="select2-blue"
							style="width: 100%;">
						@foreach ($pernyataanSKFirst as $item)
							<option value="{{ $item->id }}">{{ $item->pernyataan_standar }}</option>
						@endforeach
					</select>
				</div>
				@error('pernyataan', 'attach_pernyataan_uk')
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
