<div class="card">
	<div class="card-header">
		<h3 class="card-title" id="tambah-unit-kerja">Tambah Unit Kerja</h3>

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
		<form action="{{ route('admin.dashboard.unit-kerja.store') }}" method="POST">
			@csrf
			@if($errors->store_unit_kerja->any())
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<h6>Pesan Error:</h6>
					<ul class="mb-0 pl-4">
						@foreach ($errors->store_unit_kerja->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif

			<div class="form-group">
				<label class="col-form-label" for="kode">Kode</label>
				<input
						type="text" id="kode" name="kode"
						class="form-control @error('kode', 'store_unit_kerja') is-invalid @enderror"
						value="{{ old('kode') }}"
						placeholder="Masukkan kode unit kerja..."
						autocomplete="off" autofocus
				/>
				@error('kode', 'store_unit_kerja')
				<div
						class="invalid-feedback text-danger d-block">
					{{ $message }}
				</div>
				@enderror
			</div>
			<div class="form-group">
				<label class="col-form-label" for="nama">Nama</label>
				<input
						type="text" id="nama" name="nama"
						class="form-control @error('nama', 'store_unit_kerja') is-invalid @enderror"
						value="{{ old('nama') }}"
						placeholder="Masukkan nama unit kerja..."
						autocomplete="off"
				/>
				@error('nama', 'store_unit_kerja')
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
