<div class="card">
	<div class="card-header">
		<h3 class="card-title" id="tambah-ruang-lingkup">Tambah Ruang Lingkup</h3>

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
		<form action="{{ route('admin.dashboard.ruang-lingkup.store') }}" method="POST">
			@csrf
			@if($errors->store_ruang_lingkup->any())
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<h6>Pesan Error:</h6>
					<ul class="mb-0 pl-4">
						@foreach ($errors->store_ruang_lingkup->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif

			<div class="form-group">
				<label class="col-form-label" for="tahun_ajaran_mulai">Tahun Ajaran Mulai</label>
				<div class="input-group date" id="tahun_ajaran_mulai_date_picker" data-target-input="nearest">
					<input type="text" name="tahun_ajaran_mulai" id="tahun_ajaran_mulai"
					       class="form-control datetimepicker-input @error('tahun_ajaran_mulai', 'store_ruang_lingkup') is-invalid @enderror"
					       data-target="#tahun_ajaran_mulai_date_picker"
					       value="{{ old('tahun_ajaran_mulai') }}"
					       autocomplete="off"
					/>
					<div class="input-group-append"
					     data-target="#tahun_ajaran_mulai_date_picker"
					     data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fa fa-calendar"></i></div>
					</div>
				</div>
				@error('tahun_ajaran_mulai', 'store_ruang_lingkup')
				<div class="invalid-feedback text-danger d-block">
					{{ $message }}
				</div>
				@enderror
			</div>

			<div class="form-group">
				<label class="col-form-label" for="tahun_ajaran_selesai">Tahun Ajaran Selesai</label>
				<div class="input-group date" id="tahun_ajaran_selesai_date_picker" data-target-input="nearest">
					<input type="text" name="tahun_ajaran_selesai" id="tahun_ajaran_selesai"
					       class="form-control datetimepicker-input @error('tahun_ajaran_selesai', 'store_ruang_lingkup') is-invalid @enderror"
					       data-target="#tahun_ajaran_selesai_date_picker"
					       value="{{ old('tahun_ajaran_selesai') }}"
					       autocomplete="off"
					/>
					<div class="input-group-append"
					     data-target="#tahun_ajaran_selesai_date_picker"
					     data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fa fa-calendar"></i></div>
					</div>
				</div>
				@error('tahun_ajaran_selesai', 'store_ruang_lingkup')
				<div class="invalid-feedback text-danger d-block">
					{{ $message }}
				</div>
				@enderror
			</div>

			<div class="form-group">
				<label class="col-form-label" for="semester">Semester</label>
				<select
						id="semester" name="semester"
						class="form-control select2 @error('semester', 'store_ruang_lingkup') is-invalid @enderror"
						data-placeholder="Pilih Semester"
						style="width: 100%;">
					<option selected disabled value="">Pilih...</option>
					<option value="ganjil">Ganjil</option>
					<option value="genap">Genap</option>
				</select>
				@error('semester', 'store_ruang_lingkup')
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