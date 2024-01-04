<div class="card">
	<div class="card-header">
		<h3 class="card-title" id="tambah-sk">Tambah Standar Kriteria</h3>

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
		<form action="{{ route('admin.dashboard.standar-kriteria.store') }}" method="POST">
			@csrf
			@if($errors->store_standar_kriteria->any())
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<h6>Pesan Error:</h6>
					<ul class="mb-0 pl-4">
						@foreach ($errors->store_standar_kriteria->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif

			<div class="form-group">
				<label class="col-form-label" for="nama">Standar Kriteria</label>
				<input
						type="text" id="nama" name="nama"
						class="form-control @error('nama', 'store_standar_kriteria') is-invalid @enderror"
						value="{{ old('nama') }}"
						placeholder="Tuliskan nama standar..."
						autocomplete="off"
						autofocus/>
				@error('nama', 'store_standar_kriteria')
				<div
						class="invalid-feedback text-danger d-block">
					{{ $message }}
				</div>
				@enderror
			</div>

			<div class="form-group">
				<label class="col-form-label" for="kategori">Kategori Standar Kriteria</label>
				<small class="d-block text-gray">Contoh: Standar Penelitian Mahasiswa</small>
				<input
						type="text" id="kategori" name="kategori"
						class="form-control @error('kategori', 'store_standar_kriteria') is-invalid @enderror"
						value="{{ old('kategori') }}"
						placeholder="Tuliskan kategori..."
						autocomplete="off"/>
				@error('kategori', 'store_standar_kriteria')
				<div
						class="invalid-feedback text-danger d-block">
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
