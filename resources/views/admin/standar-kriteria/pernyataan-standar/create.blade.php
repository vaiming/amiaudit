<div class="card">
	<div class="card-header">
		<h3 class="card-title" id="tambah-sk-pernyataan">Tambah Pernyataan</h3>

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
		<form action="{{ route('admin.dashboard.standar-kriteria.pernyataan.store', [$sk_detail->id]) }}"
		      method="POST">
			@csrf
			@if($errors->store_pernyataan->any())
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<h6>Pesan Error:</h6>
					<ul class="mb-0 pl-4">
						@foreach ($errors->store_pernyataan->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif

			<div class="form-group">
				<label class="col-form-label" for="pernyataan">Pernyataan Standar</label>
				<textarea
						type="text" id="pernyataan" name="pernyataan" rows="4"
						class="form-control @error('pernyataan', 'store_pernyataan') is-invalid @enderror"
						placeholder="Tuliskan pernyataan standar..."
						autocomplete="off" style="resize: vertical">{{ old('pernyataan') }}</textarea>
				@error('pernyataan', 'store_pernyataan')
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
