<div class="card">
	<div class="card-header">
		<h3 class="card-title" id="tambah-indikator-pernyataan-sk">Tambah Indikator Pernyataan Standar Kriteria</h3>

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
		<form action="{{ route('admin.dashboard.standar-kriteria.pernyataan.indikator.store', [$standarKriteria->id, $pernyataan->id]) }}"
		      method="POST">
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
				       placeholder="{{ $standarKriteria->nama }}" disabled>
			</div>

			<div class="form-group">
				<label>Pernyataan Standar</label>
				<textarea class="form-control" rows="5" disabled>{{$pernyataan->pernyataan_standar}}</textarea>
			</div>

			<div class="form-group" id="indikator-form">
				<label class="col-form-label" for="number-indikator">
          Jumlah Indikator<br>
          <small class="text-muted">Masukkan angka yang menunjukkan jumlah dari indikator yang ingin ditambahkan</small>
        </label>
				<div class="input-group mb-3">
					<input type="text" name="number-indikator" value="{{ old('number-indikator') }}"
					       id="number-indikator" class="form-control @error('number-indikator') is-invalid @enderror"
					       placeholder="Masukkan Jumlah Indikator..."
					       autocomplete="off"
					>
					<div class="input-group-append">
						<input type="button" value="Tambah Indikator"
						       class="btn btn-primary" onClick="addIndikatorInput()"/>
					</div>
				</div>

				<div class="indikator-container"></div>

				@error('number-indikator')
				<div class="invalid-feedback text-danger d-block">
					{{ $message }}
				</div>
				@enderror
			</div>

			<div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
				<a href="{{ route('admin.dashboard') }}" class="btn btn-danger text-uppercase">
					Batal
				</a>
				<button class="btn btn-primary text-uppercase" type="submit">Submit</button>
			</div>
		</form>

	</div>
</div>
