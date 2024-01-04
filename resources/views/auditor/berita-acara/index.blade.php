@extends('layouts.app')

@section('title', 'Daftar Berita Acara')

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
					@if (request()->routeIs('auditor.berita-acara.indexUnitKerja'))
						<li class="breadcrumb-item active">{{__('Beranda')}}</li>
					@elseif (request()->routeIs('auditor.berita-acara.indexRiwayat') || request()->routeIs('auditor.berita-acara.indexBeritaAcara') || request()->routeIs('auditor.berita-acara.showBeritaAcara'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('auditor.berita-acara.indexUnitKerja') }}">
								{{__('Beranda')}}
							</a>
						</li>
					@endif
					@if (request()->routeIs('auditor.berita-acara.indexRiwayat'))
						<li class="breadcrumb-item active">Daftar Riwayat Berita Acara - {{ $unitKerja->nama }}</li>
					@elseif (request()->routeIs('auditor.berita-acara.indexBeritaAcara') || request()->routeIs('auditor.berita-acara.showBeritaAcara'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('auditor.berita-acara.indexRiwayat', [$unitKerja->id]) }}">
								Daftar Riwayat Berita Acara - {{ $unitKerja->nama }}
							</a>
						</li>
					@endif
					@if (request()->routeIs('auditor.berita-acara.indexBeritaAcara'))
						<li class="breadcrumb-item active">Daftar Berita Acara</li>
					@elseif (request()->routeIs('auditor.berita-acara.showBeritaAcara'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('auditor.berita-acara.indexBeritaAcara', [$unitKerja->id, $riwayatAudit->id]) }}">
								Daftar Berita Acara
							</a>
						</li>
					@endif
					@if (request()->routeIs('auditor.berita-acara.showBeritaAcara'))
						<li class="breadcrumb-item active">Detail Berita Acara</li>
					@endif
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Berita Acara</h1>
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
						@if (request()->routeIs('auditor.berita-acara.indexUnitKerja') && session()->has('status') && session()->has('message'))
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
								<th class="text-center text-nowrap">Total Riwayat Berita Acara</th>
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
										   href="{{ route('auditor.berita-acara.indexRiwayat', [$item->id]) }}#riwayat-berita-acara">
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

		@if (request()->routeIs('auditor.berita-acara.indexRiwayat') || request()->routeIs('auditor.berita-acara.indexBeritaAcara') || request()->routeIs('auditor.berita-acara.showBeritaAcara'))
			<div class="row">
				<section class="col">
					<!-- Default box -->
					<div class="card" id="riwayat-berita-acara">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar Riwayat Berita Acara</h3>

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
							@if (request()->routeIs('auditor.berita-acara.show') && session()->has('status') && session()->has('message'))
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
											<td class="text-bold">Unit Kerja</td>
											<td>
												<span class="ml-4">
													{{ ' : ' . ($unitKerja->nama ?? '-') }}
												</span>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>

							<table id="riwayat-berita-acara-table" class="table table-sm table-bordered table-hover"
							       style="width: 100%">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Tanggal Rencana</th>
									<th class="text-center text-nowrap">Ruang Lingkup</th>
									<th class="text-center text-nowrap">Ketua Auditee</th>
									<th class="text-center text-nowrap">Total Berita Acara</th>
									<th class="text-center text-nowrap">Aksi</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($riwayatAudits as $item)
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">
											{{parse_date_to_iso_format($item->tanggal_rencana)}}
										</td>
										<td class="text-center">
											{{ $item->ruang_lingkup_id ? $item->ruang_lingkup->getRuangLingkupFormat() : '-' }}
										</td>
										<td>
											@if ($item->auditee)
												{{$item->auditee->name}}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td class="text-center">
											{{ $item->ptks_count }}
										</td>
										<td class="text-right d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											<a class="btn btn-primary btn-xs text-nowrap"
											   href="{{ route('auditor.berita-acara.indexBeritaAcara', [$unitKerja->id, $item->id]) }}#berita-acaras">
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

		@if (request()->routeIs('auditor.berita-acara.indexBeritaAcara') || request()->routeIs('auditor.berita-acara.showBeritaAcara'))
			<div class="row">
				<section class="col">
					<!-- Default box -->
					<div class="card" id="berita-acaras">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar Berita Acara</h3>

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
							@if (request()->routeIs('auditor.berita-acara.show') && session()->has('status') && session()->has('message'))
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
													{{ ' : ' . parse_date_to_iso_format($riwayatAudit->tanggal_rencana) }}
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
	                        @if ($riwayatAudit->ruang_lingkup)
		                        {{ $riwayatAudit->ruang_lingkup->getRuangLingkupFormat() }}
	                        @else
		                        -
	                        @endif
                        </span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Jumlah Temuan PTK:</td>
											<td>
                        <span class="ml-4">
	                        {{ ' : ' . $riwayatAudit->ptks->where('type', 'PTK')->count() }}
                        </span>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Jumlah Temuan OAI:</td>
											<td>
                        <span class="ml-4">
	                        {{ ' : ' . $riwayatAudit->ptks->where('type', 'OAI')->count() }}
                        </span>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
								<div class="mb-4">
									<a href="{{ route('auditor.berita-acara.pdf', [$unitKerja->id, $riwayatAudit->id]) }}"
									   class="btn btn-primary">
										<i class="mr-2 fas fa-file"></i>PDF
									</a>
								</div>
							</div>

							<table id="berita-acaras-table" style="width: 100%"
							       class="table table-sm table-bordered table-hover">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Tipe Temuan</th>
                  <th class="text-center text-nowrap">Temuan</th>
									<th class="text-center text-nowrap">Tindakan Perbaikan</th>
									<th class="text-center text-nowrap">Aksi</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($ptks as $item)
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">{{ $item->type }}</td>
                    <td>
                      <span class="text-bold">Problem:</span>
                      {{\Str::limit($item->problem, 50)}}<br>
                      <span class="text-bold">Location:</span>
                      {{\Str::limit($item->location, 50)}}<br>
                      <span class="text-bold">Objective:</span>
                      {{\Str::limit($item->objective, 50)}}<br>
                      <span class="text-bold">Reference:</span>
                      {{\Str::limit($item->reference, 50)}}<br>
                    </td>
										<td>
											{{ \Str::limit($item->rencana_tindakan_perbaikan, 50) }}
										</td>
										<td class="text-right d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											<a class="btn btn-primary btn-xs text-nowrap"
											   href="{{ route('auditor.berita-acara.showBeritaAcara', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}#detail-berita-acara">
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

		@if (request()->routeIs('auditor.berita-acara.showBeritaAcara'))
			<div class="row">
				<section class="col-xl-6 col-lg-9 col-md-10 col-sm-11 col-12">
					<!-- Default box -->
					<div class="card" id="detail-berita-acara">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Detail Berita Acara</h3>

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
							@if (request()->routeIs('auditor.berita-acara.show') && session()->has('status') && session()->has('message'))
								<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
									<span>{!!session()->get('message')!!}</span>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif

							<div class="d-flex flex-column">
								<div>
									<span class="text-bold">Auditor</span>
									<p>{{ $ptk->auditor->name ?? 'Tidak ada'}}</p>
								</div>
								<div>
									<span class="text-bold">Auditee</span>
									<p>{{ $ptk->auditee->name ?? 'Tidak ada'}}</p>
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
									<p>{{ $ptk->checklist_audit->measure->measure ?? 'Tidak ada'}}</p>
								</div>
                <div>
                  <span class="text-bold">Deskripsi Ketidaksesuaian</span>
                  <table class="mb-3">
                    <tbody>
                    <tr>
                      <td class="text-bold">Problem</td>
                      <td>{{ ' : ' . $ptk->problem }}</td>
                    </tr>
                    <tr>
                      <td class="text-bold">Location</td>
                      <td>{{ ' : ' . $ptk->location }}</td>
                    </tr>
                    <tr>
                      <td class="text-bold">Objective</td>
                      <td>{{ ' : ' . $ptk->objective }}</td>
                    </tr>
                    <tr>
                      <td class="text-bold">Reference</td>
                      <td>{{ ' : ' . $ptk->reference }}</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
								<div>
									<div class="text-bold">
                    Tindakan Perbaikan
									</div>
									<p>{{ $ptk->rencana_tindakan_perbaikan ?? 'Tidak ada' }}</p>
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
	@include('auditor.sidebar')
@endsection

@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Select2 -->
	<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- DataTables & Plugins -->
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

	<script type="text/javascript">
		$(document).ready(function () {
        /*Datatables*/
        $('#unit-kerja-table').DataTable({
            "info": true,
            "autoWidth": true,
            "scrollX": true,
        });

        $('#riwayat-berita-acara-table').DataTable({
            "info": true,
            "autoWidth": true,
            "scrollX": true,
        });

        $('#berita-acaras-table').DataTable({
            "info": true,
            "autoWidth": true,
            "scrollX": true,
        });
    })
	</script>
@endsection
