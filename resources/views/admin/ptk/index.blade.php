@extends('layouts.app')

@section('title', 'Daftar PTK Unit')

@section('styles')
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
	      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Select2 -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<!-- DataTables -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
@endsection

@section('content-header')
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col">
				<ol class="text-sm breadcrumb float-sm-right">
					@if (request()->routeIs('admin.ptk.indexUnitKerja'))
						<li class="breadcrumb-item active">{{__('Beranda')}}</li>
					@elseif (request()->routeIs('admin.ptk.riwayat-audit.index') || request()->routeIs('admin.ptk.riwayat-audit.show') || request()->routeIs('admin.ptk.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.ptk.indexUnitKerja') }}">
								{{__('Beranda')}}
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.ptk.riwayat-audit.index'))
						<li class="breadcrumb-item active">Daftar Riwayat PTK - {{ $unitKerja->nama }}</li>
					@elseif (request()->routeIs('admin.ptk.riwayat-audit.show') || request()->routeIs('admin.ptk.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.ptk.riwayat-audit.index', [$unitKerja->id]) }}">
								Daftar Riwayat PTK - {{ $unitKerja->nama }}
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.ptk.riwayat-audit.show'))
						<li class="breadcrumb-item active">Daftar PTK Unit</li>
					@elseif (request()->routeIs('admin.ptk.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.ptk.riwayat-audit.index', [$unitKerja->id]) }}">
								Daftar PTK Unit
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.ptk.show'))
						<li class="breadcrumb-item active">Detail PTK Unit</li>
					@endif
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">PTK Unit</h1>
			</div>
		</div>
	</div>
@endsection

@section('main-content')
	<div class="container-fluid">
		<div class="row">
			<section class="col" id="unit-kerja">
				<div class="card">
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
						@if (request()->routeIs('admin.ptk.indexUnitKerja') && session()->has('status') && session()->has('message'))
							<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
								<span>{!!session()->get('message')!!}</span>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@endif

						<table id="unit-kerja-table" style="width: 100%"
						       class="table table-sm table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th class="text-center text-nowrap">No</th>
								<th class="text-center text-nowrap">Unit Kerja</th>
								<th class="text-center text-nowrap">Total Riwayat PTK</th>
								<th class="text-center text-nowrap">Aksi</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($unitKerjas as $item)
								<tr>
									<td class="text-center">{{ $loop->iteration }}</td>
									<td>{{ $item->nama }}</td>
									<td class="text-center">
										{{ $item->riwayat_audits_count }}
									</td>
									<td class="text-right d-flex justify-content-center align-items-center flex-wrap" style="gap: 0.5rem">
										<a class="btn btn-primary btn-xs text-nowrap"
										   href="{{ route('admin.ptk.riwayat-audit.index', [$item->id]) }}#history-ptk">
											<i class="mr-2 fas fa-eye"></i>Show
										</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>

		@if (request()->routeIs('admin.ptk.riwayat-audit.index') || request()->routeIs('admin.ptk.riwayat-audit.show') || request()->routeIs('admin.ptk.show'))
			<div class="row">
				<section class="col">
					<div class="card" id="history-ptk">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar Riwayat PTK/OAI</h3>

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
							@if (request()->routeIs('admin.ptk.riwayat-audit.index') && session()->has('status') && session()->has('message'))
								<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
									<span>{!!session()->get('message')!!}</span>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif

							<div class="mb-4 d-flex flex-row justify-content-between">
								<div class="d-flex justify-content-end">
									<table>
										<tbody>
										<tr>
											<td class="text-bold">Unit Kerja</td>
											<td>
												<span class="ml-4">{{ ' : ' . $unitKerja->nama }}</span>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>

							<table id="riwayat-ptk-table" style="width: 100%"
							       class="table table-sm table-striped table-bordered table-hover">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Tanggal Rencana</th>
									<th class="text-center text-nowrap">Ruang Lingkup</th>
									<th class="text-center text-nowrap">Tim Auditor</th>
									<th class="text-center text-nowrap">Ketua Auditee</th>
									<th class="text-center text-nowrap">Total PTK</th>
									<th class="text-center text-nowrap">Aksi</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($riwayatAudits as $item)
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">
											{{ \Carbon\Carbon::parse($item->tanggal_rencana)->locale(config('app.locale'))->timezone(config('app.timezone'))->isoFormat('LL') }}
										</td>
										<td class="text-center">
											{{ $item->ruang_lingkup_id ? $item->ruang_lingkup->getRuangLingkupFormat() : '-' }}
										</td>
										<td class="text-center">
											{{ $item->auditors_count }}
										</td>
										<td>
											@if ($item->auditee)
												{{ $item->auditee->name}}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td class="text-center">
											{{ $item->ptks_count ?: 0 }}
										</td>
										<td class="text-right d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											<a class="btn btn-primary btn-xs text-nowrap"
											   href="{{ route('admin.ptk.riwayat-audit.show', [$unitKerja->id, $item->id]) }}#ptks-table">
												<i class="mr-2 fas fa-eye"></i>Show
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>
		@endif

		@if (request()->routeIs('admin.ptk.riwayat-audit.show') || request()->routeIs('admin.ptk.show'))
			<div class="row">
				<section class="col">
					<!-- Default box -->
					<div class="card" id="ptks">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar PTK/OAI</h3>

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
							@if (request()->routeIs('admin.ptk.riwayat-audit.show') && session()->has('status') && session()->has('message'))
								<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
									<span>{!!session()->get('message')!!}</span>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif

							<div class="d-flex flex-row justify-content-between">
								<div class="mb-4 d-flex justify-content-end">
									<table>
										<tbody>
										<tr>
											<td class="text-bold">Tanggal Rencana</td>
											<td>
												<span class="ml-4">
													{{ ' : ' . \Carbon\Carbon::parse($riwayatAudit->tanggal_rencana)->locale(config('app.locale'))->timezone(config('app.timezone'))->isoFormat('LL') }}
												</span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Unit Kerja</td>
											<td>
												<span class="ml-4">
													{{ ' : ' . ($riwayatAudit->unit_kerja->nama ?? '-') }}
												</span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Tim Auditor</td>
											<td>
												<span class="ml-4">
	                        {{ ' : ' }}
													@if ($riwayatAudit->auditors->isNotEmpty())
														{{ $riwayatAudit->auditors->pluck('name')->join(', ', ' dan ') }}
													@else
														-
													@endif
												</span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Ketua Auditee</td>
											<td>
												<span class="ml-4">
													{{ ' : ' }}
													{{ $riwayatAudit->auditee->name ?? '-' }}
												</span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Lokasi</td>
											<td>
												<span class="ml-4">
													{{ ' : ' . $riwayatAudit->lokasi }}
												</span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Ruang Lingkup</td>
											<td>
                        <span class="ml-4">
	                        {{ ' : ' }}
	                        @if ($riwayatAudit->ruang_lingkup_id)
		                        {{ $riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
	                        @else
		                        -
	                        @endif
                        </span>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
                <div class="mb-4">
                  <a href="{{ route('admin.ptk.riwayat-pdf', [$unitKerja->id, $riwayatAudit->id]) }}"
                     class="btn btn-primary">
                    <i class="mr-2 fas fa-file"></i>PDF
                  </a>
                </div>
							</div>

							<table id="ptks-table" style="width: 100%"
							       class="table table-sm table-bordered table-hover">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Tipe Temuan</th>
									<th class="text-center text-nowrap">Standar Kriteria</th>
									<th class="text-center text-nowrap">Measure</th>
									<th class="text-center text-nowrap">Auditor</th>
									<th class="text-center text-nowrap">Auditee</th>
									<th class="text-center text-nowrap">Status</th>
									<th class="text-center text-nowrap">Aksi</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($checklistAudits as $item)
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">{{ $item->ptk->type ?? '-' }}</td>
										<td>
											@if ($item->standarKriteria)
												{{ $item->standarKriteria->nama }}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td>
											@if ($item->measure)
												{{ \Str::limit($item->measure->measure, 50) }}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td>
											@if ($item->auditor)
												{{ $item->auditor->name }}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td>
											@if ($item->auditee)
												{{ $item->auditee->name }}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td class="text-center text-nowrap">
											@if ($item->ptk)
												@if ($item->ptk->is_approved_with_repaired_by_auditor)
													<span style="padding:.125rem .75rem;" class="bg-info text-sm rounded-pill"
													>Ditutup</span>
												@elseif ($item->ptk->is_approved_by_auditee && $item->ptk->is_approved_by_auditor)
													<span style="padding:.125rem .75rem;" class="bg-warning text-sm rounded-pill"
													>Sedang Proses</span>
												@else
													<span style="padding:.125rem .75rem;" class="bg-secondary text-sm rounded-pill"
													>Belum Ada Tindakan</span>
												@endif
											@else
												<span style="padding:.125rem .75rem;" class="bg-secondary text-sm rounded-pill"
												>Data PTK/OAI Belum Tersedia</span>
											@endif
										</td>
										<td class="text-right d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											@if ($item->ptk)
												<a href="{{ route('admin.ptk.pdf', [$unitKerja->id, $riwayatAudit->id, $item->id, $item->ptk->id, 'number' => $loop->iteration]) }}"
												   class="btn btn-xs btn-primary">
													<i class="mr-2 fas fa-file"></i>PDF
												</a>
												<a class="btn btn-primary btn-xs text-nowrap"
												   href="{{ route('admin.ptk.show', [$unitKerja->id, $riwayatAudit->id, $item->id, $item->ptk->id]) }}#detail-ptk"
												   title="Tampilkan Detail"
												><i class="mr-2 fas fa-eye"></i>Show
												</a>
											@else
												<a href="{{ route('admin.ptk.create', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}"
												   class="btn btn-primary btn-xs text-nowrap"
												   title="Tambah Data PTK"
												><i class="mr-1 fas fa-plus"></i>PTK/OAI
												</a>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>
		@endif

		@if (request()->routeIs('admin.ptk.show'))
			<div class="row">
				<section class="col-xl-6 col-lg-9 col-md-10 col-sm-11 col-12">
					<!-- Default box -->
					<div class="card" id="detail-ptk">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Detail PTK Unit</h3>

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
							@if (request()->routeIs('admin.ptk.riwayat-audit.show') || request()->routeIs('admin.ptk.show') && session()->has('status') && session()->has('message'))
								<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
									<span>{!!session()->get('message')!!}</span>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif

							@if ($ptk->is_approved_with_repaired_by_auditor)
								<div class="alert alert-success text-center" style="opacity:.9;" role="alert">
									Perbaikan Sudah Diselesaikan
								</div>
							@elseif ($ptk->is_approved_by_auditee && $ptk->is_approved_by_auditor)
								<div class="alert alert-warning text-center" style="opacity:.9;" role="alert">
									<p class="m-0">Sedang Dalam Masa Perbaikan</p>
									@if ($finishDateTime->addDay()->isPast())
                    <p class="p-0 m-0 text-red text-bold">Waktu sudah melebihi batas</p>
                    <i class="mr-2 fas fa-clock"></i>
                    <span class="text-red text-bold">{{ $remainingDateTime->forHumans() }}</span>
									@else
                    <p class="p-0 m-0 text-bold">Waktu yang tersisa</p>
                    <i class="mr-2 fas fa-clock"></i>{{ $remainingDateTime->forHumans().' lagi' }}
									@endif
								</div>
							@endif

							<div class="d-flex flex-column">
								<div>
									<span class="text-bold">Auditor</span>
									<p>{{ $ptk->auditor->name ?? 'Tidak ada' }}</p>
								</div>
								<div>
									<span class="text-bold">Auditee</span>
									<p>{{ $ptk->auditee->name ?? 'Tidak ada' }}</p>
								</div>
								<div>
									<span class="text-bold">Tipe Temuan</span>
									<p>{{ $ptk->type }}</p>
								</div>
								<div>
									<span class="text-bold">Standar Kriteria</span>
									<p>{{ $ptk->checklist_audit->standarKriteria->nama ?? 'Tidak ada' }}</p>
								</div>
								<div>
									<span class="text-bold">Pernyataan Standar</span>
									<p>{{ $ptk->checklist_audit->pernyataan_standar->pernyataan_standar ?? 'Tidak ada' }}</p>
								</div>
								<div>
									<span class="text-bold">Indikator</span>
									<p>{{ $ptk->checklist_audit->indikator->indikator ?? 'Tidak ada' }}</p>
								</div>
								<div>
									<span class="text-bold">Measure</span>
									<p>{{ $ptk->checklist_audit->measure->measure ?? 'Tidak ada' }}</p>
								</div>

								<div>
									<span class="text-bold">Deskripsi Ketidaksesuaian</span>
									<table class="mb-3">
										<tbody>
										<tr>
											<td class="text-bold">Problem</td>
											<td>
												<span class="ml-2">
													{{ ' : ' . $ptk->problem }}
												</span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Location</td>
											<td>
												<span class="ml-2">
													{{ ' : ' . $ptk->location }}
												</span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Objective</td>
											<td>
												<span class="ml-2">
													{{ ' : ' . $ptk->objective }}
												</span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Reference</td>
											<td>
												<span class="ml-2">
													{{ ' : ' . $ptk->reference }}
												</span>
											</td>
										</tr>
										</tbody>
									</table>
								</div>

								<div>
									<span class="text-bold">Analisa Akar Masalah</span>
									<p>{{ $ptk->analisa_akar_masalah }}</p>
								</div>
								<div>
									<span class="text-bold">Akibat</span>
									<p>{{ $ptk->akibat }}</p>
								</div>
								<div>
									<span class="text-bold">Rekomendasi/Permintaan Tindakan Koreksi</span>
									<p>{{ $ptk->permintaan_tindakan_koreksi }}</p>
								</div>
								<div>
									<span class="text-bold">Rencana Tindakan Perbaikan</span>
									<p>{{ $ptk->rencana_tindakan_perbaikan }}</p>
								</div>
								<div>
									<span class="text-bold">Rencana Pencegahan</span>
									<p>{{ $ptk->rencana_pencegahan }}</p>
								</div>
								<div>
									<span class="text-bold">Penanggung Jawab Perbaikan</span>
									<p>{{ $ptk->penanggungJawabPerbaikan->nama ?? '-' }}</p>
								</div>
								<div>
									<span class="text-bold">Waktu Mulai Perbaikan</span>
									<p>{{ $startDateTime ? $startDateTime->isoFormat('LL') : '-' }}</p>
								</div>
								<div>
									<span class="text-bold">Batas Waktu Perbaikan</span>
									<p>{{ $finishDateTime ? $finishDateTime->isoFormat('LL') : '-' }}</p>
								</div>
                <div>
                  <span class="text-bold">Status Temuan oleh Auditor</span>
                  @if ($ptk->is_approved_by_auditor)
                    <p class="text-md d-flex align-items-center">
                      <i class="mr-1 fas fa-check-circle text-green text-lg"></i> Telah Disetujui
                    </p>
                  @else
                    <p class="text-md d-flex align-items-center">
                      <i class="mr-1 fas fa-exclamation-circle text-yellow text-lg"></i> Belum Disetujui
                    </p>
                  @endif
                </div>
                <div>
                  <span class="text-bold">Status Temuan oleh Auditee</span>
                  @if ($ptk->is_approved_by_auditee)
                    <p class="text-md d-flex align-items-center">
                      <i class="mr-1 fas fa-check-circle text-green text-lg"></i> Telah Disetujui
                    </p>
                  @else
                    <p class="text-md d-flex align-items-center">
                      <i class="mr-1 fas fa-exclamation-circle text-yellow text-lg"></i> Belum Disetujui
                    </p>
                  @endif
                </div>
                @if ($ptk->is_approved_by_auditor && $ptk->is_approved_by_auditee)
                  <div>
                    <span class="text-bold">Status Perbaikan oleh Auditor</span>
                    @if ($ptk->is_approved_with_repaired_by_auditor)
                      <p class="text-md d-flex align-items-center">
                        <i class="mr-1 fas fa-check-circle text-green text-lg"></i> Telah Disetujui
                      </p>
                    @else
                      <p class="text-md d-flex align-items-center">
                        <i class="mr-1 fas fa-exclamation-circle text-yellow text-lg"></i> Belum Disetujui
                      </p>
                    @endif
                  </div>
                @endif
							</div>

							<div class="mt-2 d-flex flex-column justify-content-center align-items-center" style="gap: .5rem">
								<div class="d-flex flex-column justify-content-center align-items-center" style="gap: .5rem">
									@if ($ptk->is_approved_by_auditor && $ptk->is_approved_by_auditee)
										{{--Jika persetujuan dari kedua belah pihak telah terpenuhi mengenai temuan yang akan dijadikan PTK ini--}}
										@if ($ptk->is_approved_with_repaired_by_auditor)
											{{--Jika seluruhnya telah terselesaikan--}}
											<div class="d-flex flex-wrap justify-content-center align-items-center" style="gap: .25rem">
												<a class="btn btn-default text-nowrap ptk-markAsPerbaikanNotApprovedYetAuditor-btn"
												   href="{{ route('admin.ptk.markAsPerbaikanNotApprovedYetAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
												   onclick="event.preventDefault();document.getElementById('ptk-markAsPerbaikanNotApprovedYetAuditor-form-{{ $ptk->id}}').submit()"
												><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Perbaikan Belum Disetujui Auditor
												</a>
												<form id="ptk-markAsPerbaikanNotApprovedYetAuditor-form-{{ $ptk->id }}" class="d-none"
												      method="POST"
												      action="{{ route('admin.ptk.markAsPerbaikanNotApprovedYetAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
													@csrf
													@method("PUT")
												</form>
											</div>
										@else
											{{--Jika telah tersetujui temuannya, dan akan melakukan persetujuan proses tindakan perbaikan --}}
											<div class="d-flex flex-wrap justify-content-center align-items-center" style="gap: .25rem">
												@if ($ptk->is_approved_with_repaired_by_auditor)
													{{--Jika persetujuan perbaikan telah disetujui oleh Auditor--}}
													<a class="btn btn-default text-nowrap ptk-markAsPerbaikanNotApprovedYetAuditor-btn"
													   href="{{ route('admin.ptk.markAsPerbaikanNotApprovedYetAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
													   onclick="event.preventDefault();document.getElementById('ptk-markAsPerbaikanNotApprovedYetAuditor-form-{{ $ptk->id}}').submit()"
													><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Perbaikan Belum Disetujui Auditor
													</a>
													<form id="ptk-markAsPerbaikanNotApprovedYetAuditor-form-{{ $ptk->id }}" class="d-none"
													      method="POST"
													      action="{{ route('admin.ptk.markAsPerbaikanNotApprovedYetAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
														@csrf
														@method("PUT")
													</form>
												@else
													{{--Jika membutuhkan persetujuan perbaikan oleh Auditor--}}
													<a class="btn btn-default text-nowrap ptk-markAsPerbaikanApprovedAuditor-btn"
													   href="{{ route('admin.ptk.markAsPerbaikanApprovedAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
													   onclick="event.preventDefault();document.getElementById('ptk-markAsPerbaikanApprovedAuditor-form-{{ $ptk->id}}').submit()"
													><i class="mr-2 fas fa-check text-md"></i>Tandai Perbaikan Telah Disetuju Auditor
													</a>
													<form id="ptk-markAsPerbaikanApprovedAuditor-form-{{ $ptk->id }}" class="d-none" method="POST"
													      action="{{ route('admin.ptk.markAsPerbaikanApprovedAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
														@csrf
														@method("PUT")
													</form>
												@endif
											</div>

											<div class="d-flex flex-wrap justify-content-center align-items-center" style="gap: .25rem">
												<a class="btn btn-default text-nowrap ptk-markAsTemuanNotApprovedYetAuditor-btn"
												   href="{{ route('admin.ptk.markAsTemuanNotApprovedYetAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
												   onclick="event.preventDefault();document.getElementById('ptk-markAsTemuanNotApprovedYetAuditor-form-{{ $ptk->id}}').submit()"
												><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Temuan Belum Disetuju Auditor
												</a>
												<form id="ptk-markAsTemuanNotApprovedYetAuditor-form-{{ $ptk->id }}" class="d-none"
												      method="POST"
												      action="{{ route('admin.ptk.markAsTemuanNotApprovedYetAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
													@csrf
													@method("PUT")
												</form>
												<a class="btn btn-default text-nowrap ptk-markAsTemuanNotApprovedYetAuditee-btn"
												   href="{{ route('admin.ptk.markAsTemuanNotApprovedYetAuditee', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
												   onclick="event.preventDefault();document.getElementById('ptk-markAsTemuanNotApprovedYetAuditee-form-{{ $ptk->id}}').submit()"
												><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Temuan Belum Disetuju Auditee
												</a>
												<form id="ptk-markAsTemuanNotApprovedYetAuditee-form-{{ $ptk->id }}" class="d-none"
												      method="POST"
												      action="{{ route('admin.ptk.markAsTemuanNotApprovedYetAuditee', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
													@csrf
													@method("PUT")
												</form>
											</div>
										@endif
									@else
										{{--Jika membutuhkan persetujuan dari kedua belah pihak mengenai temuan yang akan dijadikan PTK ini--}}
										<div class="d-flex flex-wrap justify-content-center align-items-center" style="gap: .25rem">
											@if ($ptk->is_approved_by_auditor)
												{{--Jika persetujuan temuan telah disetujui oleh Auditor--}}
												<a class="btn btn-default text-nowrap ptk-markAsTemuanNotApprovedYetAuditor-btn"
												   href="{{ route('admin.ptk.markAsTemuanNotApprovedYetAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
												   onclick="event.preventDefault();document.getElementById('ptk-markAsTemuanNotApprovedYetAuditor-form-{{ $ptk->id}}').submit()"
												><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Temuan Belum Disetuju Auditor
												</a>
												<form id="ptk-markAsTemuanNotApprovedYetAuditor-form-{{ $ptk->id }}" class="d-none"
												      method="POST"
												      action="{{ route('admin.ptk.markAsTemuanNotApprovedYetAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
													@csrf
													@method("PUT")
												</form>
											@else
												{{--Jika membutuhkan persetujuan temuan oleh Auditor--}}
												<a class="btn btn-default text-nowrap ptk-markAsTemuanApprovedAuditor-btn"
												   href="{{ route('admin.ptk.markAsTemuanApprovedAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
												   onclick="event.preventDefault();document.getElementById('ptk-markAsTemuanApprovedAuditor-form-{{ $ptk->id}}').submit()"
												><i class="mr-2 fas fa-check text-md"></i>Tandai Temuan Telah Disetuju Auditor
												</a>
												<form id="ptk-markAsTemuanApprovedAuditor-form-{{ $ptk->id }}" class="d-none" method="POST"
												      action="{{ route('admin.ptk.markAsTemuanApprovedAuditor', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
													@csrf
													@method("PUT")
												</form>
											@endif

											@if ($ptk->is_approved_by_auditee)
												{{--Jika persetujuan temuan telah disetujui oleh Auditee--}}
												<a class="btn btn-default text-nowrap ptk-markAsTemuanNotApprovedYetAuditee-btn"
												   href="{{ route('admin.ptk.markAsTemuanNotApprovedYetAuditee', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
												   onclick="event.preventDefault();document.getElementById('ptk-markAsTemuanNotApprovedYetAuditee-form-{{ $ptk->id}}').submit()"
												><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Temuan Belum Disetuju Auditee
												</a>
												<form id="ptk-markAsTemuanNotApprovedYetAuditee-form-{{ $ptk->id }}" class="d-none"
												      method="POST"
												      action="{{ route('admin.ptk.markAsTemuanNotApprovedYetAuditee', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
													@csrf
													@method("PUT")
												</form>
											@else
												{{--Jika membutuhkan persetujuan temuan oleh Auditee--}}
												<a class="btn btn-default text-nowrap ptk-markAsTemuanApprovedAuditee-btn"
												   href="{{ route('admin.ptk.markAsTemuanApprovedAuditee', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
												   onclick="event.preventDefault();document.getElementById('ptk-markAsTemuanApprovedAuditee-form-{{ $ptk->id}}').submit()"
												><i class="mr-2 fas fa-check text-md"></i>Tandai Temuan Telah Disetuju Auditee
												</a>
												<form id="ptk-markAsTemuanApprovedAuditee-form-{{ $ptk->id }}" class="d-none" method="POST"
												      action="{{ route('admin.ptk.markAsTemuanApprovedAuditee', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
													@csrf
													@method("PUT")
												</form>
											@endif
										</div>
									@endif
								</div>

								<div class="d-flex justify-content-center align-items-center" style="gap: .25rem">
									<a class="btn btn-warning btn-sm text-nowrap"
									   href="{{ route('admin.ptk.edit', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
										<i class="mr-2 fas fa-pencil-alt"></i>Edit
									</a>
									<a class="btn btn-danger btn-sm text-nowrap detail-ptk-delete-btn"
									   data-ptk-id="{{ $ptk->id}}"
									   data-is-approved-as-temuan="{{ $ptk->is_approved_by_auditor && $ptk->is_approved_by_auditee ? 1:0}}"
									   href="{{ route('admin.ptk.destroy', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}"
									><i class="mr-2 fas fa-trash"></i>Delete
									</a>
									<form id="detail-ptk-delete-form-{{ $ptk->id }}" class="d-none" method="POST"
									      action="{{ route('admin.ptk.destroy', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id]) }}">
										@csrf
										@method("DELETE")
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		@endif
	</div>
@endsection

@section('sidebar')
	@include('admin.sidebar')
@endsection

@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Select2 -->
	<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- DataTables  & Plugins -->
	<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

	<!-- Page specific script -->
	<script>
      $(document).ready(function () {
          /*SweetAlert2*/
          const ConfirmSwal2 = Swal.mixin({
              confirmButtonText: 'Ya', confirmButtonAriaLabel: 'Ya',
              showCancelButton: true, cancelButtonText: 'Kembali',
              cancelButtonAriaLabel: 'Kembali',
              showCloseButton: true,
              customClass: {
                  confirmButton: 'mx-1 btn btn-primary',
                  cancelButton: 'mx-1 btn btn-outline-danger'
              },
              buttonsStyling: false,
          });
          const AlertSwal2 = Swal.mixin({
              showCloseButton: true,
              customClass: {
                  confirmButton: 'mx-1 btn btn-primary',
                  cancelButton: 'mx-1 btn btn-outline-danger'
              },
              buttonsStyling: false,
          });

          /*Delete Unit Kerja*/
          $('#detail-ptk .detail-ptk-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "PTK ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if ($($el).data().isApprovedAsTemuan) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: "Maaf, Anda tidak bisa menghapus PTK/OAI ini karena telah menjadi dokumen temuan yang sah.",
                              });
                          } else {
                              $(`#detail-ptk-delete-form-${$($el).data().ptkId}`).submit()
                          }
                      }
                  })
              });
          });
          /*SweetAlert2*/

          /*Datatables*/
          $('#unit-kerja-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });

          $('#riwayat-ptk-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });

          $('#ptks-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });
          /*Datatables*/

          /*Select2*/
          $('.select2').select2()

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          })
      });
	</script>
@endsection
