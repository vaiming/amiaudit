<div class="card">
	<div class="card-header">
		<h3 class="card-title" id="remove-pernyataan-uk">Edit Pernyataan Unit Kerja</h3>

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
		<form
				action="{{ route('admin.dashboard.unit-kerja.indikator.update', [$unitKerja->id, $standarKriteria->id]) }}"
				method="POST">
			@csrf
			@method('PUT')
			@if($errors->detach_pernyataan_uk->any())
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<h6>Pesan Error:</h6>
					<ul class="mb-0 pl-4">
						@foreach ($errors->detach_pernyataan_uk->all() as $error)
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

			<!-- checkbox -->
			<div class="form-group">
				<label>
          Pernyataan Standar <br>
          <small class="text-muted">Pilih pernyataan yang ingin dihilangkan</small>
        </label>
        @foreach ($pernyataansUnitKerja as $item)
					<div class="form-group clearfix">
						<div class="icheck-primary d-inline">
							<input type="checkbox" name="pernyataan-{{ $loop->iteration }}"
                     id="pernyataan-{{ $loop->iteration }}" value="{{ $item->pernyataan_standar->id }}">
							<label for="pernyataan-{{ $loop->iteration }}">
								{{ $item->pernyataan_standar->pernyataan_standar }}
							</label>
						</div>
					</div>
				@endforeach
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
