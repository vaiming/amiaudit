<div class="card" id="standar-kriteria" style="min-height: 800px">
	<div class="card-header bg-gradient-lightblue">
		<h3 class="card-title">Daftar Standar Kriteria</h3>

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
			<a href="{{ route('admin.dashboard.standar-kriteria.create') }}#tambah-sk"
			   class="btn btn-primary"
			><i class="mr-2 fas fa-plus"></i>Standar Kriteria</a>
			<br/>
		</div>

		<div class="table-data table-responsive p-0" style="max-height: 800px">
			<table class="table table-sm table-bordered table table-head-fixed table-hover">
				<thead class="thead-light">
				<tr>
					<th class="text-center text-nowrap">No</th>
					<th class="text-center text-nowrap">Kategori</th>
					<th class="text-center text-nowrap">Nama</th>
					<th class="text-center">Total Pernyataan</th>
					<th class="text-center">Total Indikator</th>
					<th class="text-center">Total Measure</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($standarKriterias as $sk)
					<tr data-widget="expandable-table" aria-expanded="{{$errors->sk_id->first() === "$sk->id" ? "true" : "false"}}">
						<td class="text-center">{{ $loop->iteration }}</td>
						<td>{{ $sk->kategori }}</td>
						<td>{{ $sk->nama }}</td>
						<td class="text-center">{{ $sk->pernyataanStandars->count() }}</td>
						<td class="text-center">{{ $sk->indikators_count }}</td>
						<td class="text-center">{{ $sk->measures_count }}</td>
					</tr>
					<tr class="expandable-body {{$errors->sk_id->first() === "$sk->id" ? "" : "d-none"}}">
						<td colspan="6">
							<h6 class="card-header bg-gradient-navy">Detail Standar Kriteria</h6>
							<ul class="pl-4">
								@foreach ($sk->pernyataanStandars as $pernyataan)
									<li>{{ $pernyataan->pernyataan_standar }}</li>
									<div class="text-bold mt-2">Indikator-indikator :</div>
									@if ($pernyataan->indikators->isNotEmpty())
										<ul class="pl-4">
											@foreach ($pernyataan->indikators as $indk)
												<li>
													{{ $indk->indikator }}
													<span class="ml-1">
                            <button type="button" class="btn btn-xs text-nowrap btn-outline-warning"
                                    data-backdrop="static" data-toggle="modal"
                                    data-target="#modal-edit-indikator-{{ $indk->id }}"
                            ><i class="mr-2 fas fa-pen"></i>Edit
                            </button>
                            <a href="{{ route('admin.dashboard.standar-kriteria.pernyataan.indikator.destroy', [$sk->id, $pernyataan->id, $indk->id]) }}"
                               class="btn btn-xs text-nowrap btn-outline-danger indikator-ps-delete-btn"
                               data-checklist-audits-count="{{$indk->checklist_audits_count}}"
                               data-indikator-id="{{$indk->id}}"
                            ><i class="mr-2 fas fa-trash"></i>Delete</a>
                            <form
		                            action="{{ route('admin.dashboard.standar-kriteria.pernyataan.indikator.destroy', [$sk->id, $pernyataan->id, $indk->id]) }}"
		                            method="post" class="d-none" id="indikator-ps-delete-form-{{ $indk->id }}">
                              @csrf
	                            @method('DELETE')
                            </form>
                          </span>

													{{-- Edit Indikator --}}
													<div class="modal fade" id="modal-edit-indikator-{{ $indk->id }}">
														<div class="modal-dialog">
															<form
																	action="{{ route('admin.dashboard.standar-kriteria.pernyataan.indikator.update', [$sk->id, $pernyataan->id, $indk->id]) }}"
																	method="POST" class="modal-content d-block">
																@csrf
																@method('PUT')
																<div class="modal-header">
																	<h5 class="modal-title">Edit Indikator Pernyataan</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
                                  @if($errors->error_key->first() === "update_indikator_$indk->id" && $errors->any())
																		<div class="alert alert-warning alert-dismissible fade show" role="alert">
																			<h6>Pesan Error:</h6>
																			<ul class="pl-4 mb-0">
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
																		<label class="col-form-label" for="indikator">Indikator</label>
																		<textarea id="indikator" name="indikator" rows="4"
                                              class="form-control" autofocus style="resize: vertical"
																		>{{ old('indikator', $indk->indikator) }}</textarea>
																		@error('indikator', 'update_indikator')
                                    @if ($errors->error_key->first() === "update_indikator_$indk->id")
                                      <div class="invalid-feedback text-danger d-block">
                                        {{ $message }}
                                      </div>
                                    @endif
																		@enderror
																	</div>
																</div>
																<div class="modal-footer justify-content-end">
																	<button type="button" class="btn btn-default text-uppercase" data-dismiss="modal"
																	>Close
																	</button>
																	<button type="submit" class="btn btn-primary text-uppercase">Submit</button>
																</div>
															</form>
														</div>
													</div>
                          {{-- Akhir Modal Edit Indikator --}}
                        </li>
											@endforeach
										</ul>
									@else
										<div class="font-weight-light font-italic">Tidak ada indikator!</div>
									@endif

									<div class="text-bold mt-2">Measure-measure :</div>
									@if ($pernyataan->measures->isNotEmpty())
										<ul class="pl-4">
											@foreach ($pernyataan->measures as $measureItem)
												<li>
													{{ $measureItem->measure }}
													<span class="ml-1">
                            <button type="button" class="btn btn-xs text-nowrap btn-outline-warning"
                                    data-backdrop="static" data-toggle="modal"
                                    data-target="#modal-edit-measure-{{ $measureItem->id }}"
                            ><i class="mr-2 fas fa-pen"></i>Edit
                            </button>
                            <a href="{{ route('admin.dashboard.standar-kriteria.pernyataan.measure.destroy', [$sk->id, $pernyataan->id, $measureItem->id]) }}"
                               class="btn btn-xs text-nowrap btn-outline-danger measure-ps-delete-btn"
                               data-pernyataan-uk-count="{{$measureItem->pernyataan_standar_unit_kerjas_count}}"
                               data-measure-ps="{{$measureItem->id}}"
                            ><i class="mr-2 fas fa-trash"></i>Delete</a>
                            <form
		                            action="{{ route('admin.dashboard.standar-kriteria.pernyataan.measure.destroy', [$sk->id, $pernyataan->id, $measureItem->id]) }}"
		                            method="post" class="d-none" id="measure-ps-delete-form-{{ $measureItem->id }}">
                              @csrf
	                            @method('DELETE')
                            </form>
                          </span>

													{{-- Edit Measure --}}
													<div class="modal fade" id="modal-edit-measure-{{ $measureItem->id }}">
														<div class="modal-dialog">
															<form action="{{ route('admin.dashboard.standar-kriteria.pernyataan.measure.update', [$sk->id, $pernyataan->id, $measureItem->id]) }}"
																	  method="POST" class="modal-content d-block"
                              >
																@csrf
																@method('PUT')
																<div class="modal-header">
																	<h5 class="modal-title">Edit Measure Pernyataan</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
                                  @if($errors->error_key->first() === "update_measure_$measureItem->id" && $errors->any())
																		<div class="alert alert-warning alert-dismissible fade show" role="alert">
																			<h6>Pesan Error:</h6>
																			<ul class="pl-4 mb-0">
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
																		<label class="col-form-label" for="measure">Measure</label>
																		<textarea id="measure" name="measure" rows="4"
																				      class="form-control" autofocus style="resize: vertical"
																		>{{ old('measure', $measureItem->measure) }}</textarea>
																		@error('measure')
                                    @if ($errors->error_key->first() === "update_measure_$measureItem->id")
                                      <div class="invalid-feedback text-danger d-block">
                                        {{ $message }}
                                      </div>
                                    @endif
																		@enderror
																	</div>
																</div>
																<div class="modal-footer justify-content-end">
																	<button type="button" class="btn btn-default text-uppercase" data-dismiss="modal"
																	>Close</button>
																	<button type="submit" class="btn btn-primary text-uppercase">Submit</button>
																</div>
															</form>
														</div>
													</div>
                          {{-- Akhir Modal Edit Measure --}}
                        </li>
											@endforeach
										</ul>
									@else
										<div class="font-weight-light font-italic">Tidak ada measure!</div>
									@endif
									<div class="mt-2">
										<a href="{{ route('admin.dashboard.standar-kriteria.pernyataan.indikator.create', [$sk->id, $pernyataan->id]) }}#tambah-indikator-pernyataan-sk"
										   class="btn btn-sm btn-info"
										><i class="mr-2 fas fa-plus"></i>Indikator
										</a>
										<a href="{{ route('admin.dashboard.standar-kriteria.pernyataan.measure.create', [$sk->id, $pernyataan->id]) }}#tambah-measure-pernyataan-sk"
										   class="btn btn-sm btn-info"
										><i class="mr-2 fas fa-plus"></i>Measure
										</a>
										<a href="{{ route('admin.dashboard.standar-kriteria.pernyataan.edit', [$sk->id, $pernyataan->id]) }}#edit-sk-pernyataan"
										   class="btn btn-sm btn-warning"
										><i class="mr-2 fas fa-pen"></i>Edit Pernyataan</a>
										<a href="{{ route('admin.dashboard.standar-kriteria.pernyataan.destroy', [$sk->id, $pernyataan->id]) }}"
										   class="btn btn-sm btn-danger pernyataan-sk-delete-btn"
										   data-pernyataan-uk-count="{{$pernyataan->pernyataan_standar_unit_kerjas_count}}"
										   data-pernyataan-sk="{{$pernyataan->id}}"
										><i class="mr-2 fas fa-trash"></i>Delete Pernyataan</a>
										<form action="{{ route('admin.dashboard.standar-kriteria.pernyataan.destroy', [$sk->id, $pernyataan->id]) }}"
												  method="post" class="d-none" id="pernyataan-sk-delete-form-{{ $pernyataan->id }}">
											@csrf
											@method('DELETE')
										</form>
									</div>
									<hr/>
								@endforeach
							</ul>
							<div class="text-center d-flex justify-content-end align-items-center" style="gap: .5rem">
								<a href="{{ route('admin.dashboard.standar-kriteria.pernyataan.create', [$sk->id]) }}#tambah-sk-pernyataan"
								   class="btn btn-sm btn-primary"
								><i class="mr-2 fas fa-plus"></i>Tambah Pernyataan</a>
								<a href="{{ route('admin.dashboard.standar-kriteria.edit', [$sk->id]) }}#edit-sk"
								   class="btn btn-sm btn-warning"
								><i class="mr-2 fas fa-pen"></i>Edit SK</a>
								<div>
									<a href="{{ route('admin.dashboard.standar-kriteria.destroy', [$sk->id]) }}"
									   class="btn btn-sm btn-danger sk-delete-btn"
                     data-pernyataan-uk-count="{{$sk->pernyataan_standar_unit_kerjas_count}}"
                     data-sk-id="{{$sk->id}}"
                  ><i class="mr-2 fas fa-trash"></i>Delete SK</a>
									<form action="{{ route('admin.dashboard.standar-kriteria.destroy', [$sk->id]) }}"
									      method="post" class="d-none" id="sk-delete-form-{{ $sk->id }}">
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
