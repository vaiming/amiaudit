<div class="card" id="ruang-lingkup" style="min-height: 700px">
	<div class="card-header bg-gradient-lightblue">
		<h3 class="card-title">Daftar Ruang Lingkup</h3>

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
		<div class="card-tools mb-4 d-flex justify-content-end">
			<a href="{{ route('admin.dashboard.ruang-lingkup.create') }}#tambah-ruang-lingkup"
			   class="btn btn-primary"
			><i class="mr-2 fas fa-plus"></i>Ruang Lingkup</a>
		</div>

		<div class="table-data table-responsive p-0" style="max-height: 400px">
			<table class="table table-sm table-bordered table-head-fixed table-hover">
				<thead>
				<tr>
					<th class="text-center text-nowrap">No</th>
					<th class="text-center text-nowrap">Tahun Ajaran</th>
					<th class="text-center text-nowrap">Semester</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($ruangLingkups as $rl)
					<tr data-widget="expandable-table" aria-expanded="false">
						<td class="text-center">{{ $loop->iteration }}</td>
						<td class="text-center">{{ $rl->tahun_ajaran_mulai.'/'.$rl->tahun_ajaran_selesai }}</td>
						<td class="text-center">{{ \Str::ucfirst($rl->semester) }}</td>
					</tr>
					<tr class="expandable-body d-none">
						<td colspan="3">
							<h6 class="card-header bg-gradient-navy">Detail Ruang Lingkup</h6>
							<div class="text-center d-flex justify-content-end align-items-center" style="gap: .5rem">
								<a href="{{ route('admin.dashboard.ruang-lingkup.edit', [$rl->id]) }}#edit-ruang-lingkup"
								   class="btn btn-sm btn-warning"
								><i class="mr-2 fas fa-pen"></i>Edit</a>
								<div>
									<a href="{{ route('admin.dashboard.ruang-lingkup.destroy', [$rl->id]) }}"
									   class="btn btn-sm btn-danger rl-delete-btn"
                     data-riwayat-audits-count="{{$rl->riwayat_audits_count}}"
                     data-rl-id="{{$rl->id}}"
									><i class="mr-2 fas fa-trash"></i>Delete</a>
									<form action="{{ route('admin.dashboard.ruang-lingkup.destroy', [$rl->id]) }}"
									      method="post" class="d-none" id="rl-delete-form-{{$rl->id}}">
										@csrf
										@method('DELETE')
									</form>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>