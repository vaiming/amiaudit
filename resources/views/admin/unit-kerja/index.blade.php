<div class="card" id="unitKerja" style="min-height: 800px">
	<div class="card-header bg-gradient-lightblue">
		<h3 class="card-title">Daftar Unit Kerja</h3>

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
			<a href="{{ route('admin.dashboard.unit-kerja.create') }}#tambah-unit-kerja"
         class="btn btn-primary"
			><i class="mr-2 fas fa-plus"></i>Unit Kerja</a>
		</div>

		<div class="table-data table-responsive p-0" style="max-height: 800px">
			<table class="table table-sm table-bordered table-head-fixed table-hover">
				<thead>
				<tr>
					<th class="text-center text-nowrap">No</th>
					<th class="text-center text-nowrap">Nama</th>
					<th class="text-center">Total Standar Kriteria</th>
					<th class="text-center">Total Measure</th>
				</tr>
				</thead>
				<tbody>
				@foreach($unitKerjas as $unitKerjaItem)
					<tr data-widget="expandable-table" aria-expanded="false">
						<td class="text-center">{{ $loop->iteration }}</td>
						<td>{{ $unitKerjaItem->nama }}</td>
						<td class="text-center">{{ $unitKerjaItem->pernyataanStandarUnitKerjas->unique('standar_kriteria_id')->map(fn ($item) => $item->standarKriteria->id)->count() }}</td>
						<td class="text-center">{{ ($unitKerjaItem->pernyataanStandarUnitKerjas->map(fn ($item) => $item->measures->count())->sum()) }}</td>
					</tr>
					<tr class="expandable-body d-none">
						<td colspan="4">
							<h6 class="card-header bg-gradient-navy">Detail Unit Kerja</h6>
							<ul class="pl-4">
								@foreach ($unitKerjaItem->pernyataanStandarUnitKerjas->unique('standar_kriteria_id') as $pernyataanUnitKerja)
									<li>{{ $pernyataanUnitKerja->standarKriteria->nama }}</li>
									<ul class="pl-4">
										@foreach ($unitKerjaItem->pernyataanStandarUnitKerjas->where('standar_kriteria_id', $pernyataanUnitKerja->standarKriteria->id) as $pernyataanUnitKerja)
											<li>{{ ($pernyataanUnitKerja->pernyataan_standar->pernyataan_standar) }}</li>
											<div class="text-bold mt-2">Measure-measure :</div>
											@if ($pernyataanUnitKerja->measures->isNotEmpty())
												<ul class="pl-4">
													@foreach ($pernyataanUnitKerja->measures as $measure)
														<li>{{ $measure->measure }}</li>
													@endforeach
												</ul>
											@else
												<div class="font-weight-light font-italic">Tidak memiliki measure!</div>
											@endif
											<div class="mt-2 d-flex" style="gap: .5rem">
												<a href="{{ route('admin.dashboard.unit-kerja.standar-kriteria.pernyataan.measure.insert', [$unitKerjaItem->id, $pernyataanUnitKerja->standarKriteria->id, $pernyataanUnitKerja->pernyataan_standar->id]) }}#tambah-measure-pernyataan-uk"
												   class="btn btn-sm text-nowrap btn-info"
												><i class="mr-2 fas fa-plus"></i>Tambah Measure</a>
												@if ($pernyataanUnitKerja->measures->isNotEmpty())
													<a href="{{ route('admin.dashboard.unit-kerja.standar-kriteria.pernyataan.measure.remove', [$unitKerjaItem->id, $pernyataanUnitKerja->standarKriteria->id, $pernyataanUnitKerja->pernyataan_standar->id]) }}#edit-measure-pernyataan-uk"
													   class="btn btn-sm text-nowrap btn-warning"
													><i class="mr-2 fas fa-pen"></i>Hapus Measure</a>
												@endif
											</div>
											<hr>
										@endforeach
									</ul>
									<div class="mt-2">
										<a href="{{ route('admin.dashboard.unit-kerja.indikator.edit', [$unitKerjaItem->id, $pernyataanUnitKerja->standarKriteria->id]) }}#remove-pernyataan-uk"
										   class="btn btn-sm btn-warning text-nowrap"
										><i class="mr-2 fas fa-pen"></i>Hapus Pernyataan</a>
									</div>
									<hr/>
								@endforeach
							</ul>
							<div class="text-center d-flex justify-content-end align-items-center" style="gap: .5rem">
								<a href="{{ route('admin.dashboard.unit-kerja.indikator.create', [$unitKerjaItem->id]) }}#tambah-pernyataan-uk"
								   class="btn btn-sm text-nowrap btn-primary"
								><i class="mr-2 fas fa-plus"></i>SK & Pernyataan</a>
								<a href="{{ route('admin.dashboard.unit-kerja.edit', [$unitKerjaItem->id]) }}#edit-unit-kerja"
								   class="btn btn-sm text-nowrap btn-warning"
								><i class="mr-2 fas fa-pen"></i>Edit</a>
								<div>
									<a href="{{ route('admin.dashboard.unit-kerja.destroy', [$unitKerjaItem->id]) }}"
									   class="btn btn-sm text-nowrap btn-danger uk-delete-btn" data-uk="{{$unitKerjaItem->id}}"
									   data-riwayat-audit-count="{{$unitKerjaItem->riwayat_audits_count}}"
									   data-auditees-count="{{$unitKerjaItem->auditees_count}}"
									><i class="mr-2 fas fa-trash"></i>Delete</a>
									<form action="{{ route('admin.dashboard.unit-kerja.destroy', [$unitKerjaItem->id]) }}"
									      method="post" class="d-none" id="uk-delete-form-{{ $unitKerjaItem->id }}">
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
