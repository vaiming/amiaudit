@extends('layouts.app')

@section('title', 'Daftar Rencana Audit Unit')

@section('styles')
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
	      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
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
					@if (request()->routeIs('admin.rencana-audit.indexUnitKerja'))
						<li class="breadcrumb-item active">{{__('Beranda')}}</li>
					@elseif (request()->routeIs('admin.rencana-audit.riwayat-audit.index') || request()->routeIs('admin.rencana-audit.riwayat-audit.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.rencana-audit.indexUnitKerja') }}">
								{{__('Beranda')}}
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.rencana-audit.riwayat-audit.index'))
						<li class="breadcrumb-item active">Daftar Riwayat Rencana Audit - {{ $unitKerja->nama }}</li>
					@elseif (request()->routeIs('admin.rencana-audit.riwayat-audit.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.rencana-audit.riwayat-audit.index', [$unitKerja->id]) }}">
								Daftar Riwayat Rencana Audit - {{ $unitKerja->nama }}
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.rencana-audit.riwayat-audit.show'))
						<li class="breadcrumb-item active">Daftar Rencana Audit</li>
					@endif
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Rencana Audit Unit</h1>
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
						@if (request()->routeIs('admin.rencana-audit.indexUnitKerja') && session()->has('status') && session()->has('message'))
							<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
								<span>{{session()->get('message')}}</span>
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
								<th class="text-center text-nowrap">Total Riwayat Rencana Audit</th>
								<th class="text-center text-nowrap">Aksi</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($unitKerjas as $item)
								<tr>
									<td class="text-center">
										{{ $loop->iteration }}
									</td>
									<td>
										{{ $item->nama }}
									</td>
									<td class="text-center">
										{{ $item->riwayat_audits_count }}
									</td>
									<td class="text-right d-flex justify-content-center align-items-center flex-wrap" style="gap: 0.5rem">
										<a class="btn btn-primary btn-xs text-nowrap"
										   href="{{ route('admin.rencana-audit.riwayat-audit.index', [$item->id]) }}#riwayat-rencana-audit">
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

		@if (request()->routeIs('admin.rencana-audit.riwayat-audit.index') || request()->routeIs('admin.rencana-audit.riwayat-audit.show'))
			<div class="row">
				<section class="col">
					<div class="card" id="riwayat-rencana-audit">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar Riwayat Rencana Audit Per Ruang Lingkup </h3>

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
							@if (request()->routeIs('admin.rencana-audit.riwayat-audit.index') && session()->has('status') && session()->has('message'))
								<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
									<span>{{session()->get('message')}}</span>
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

							<table id="riwayat-rencana-audit-table" style="width: 100%"
							       class="table table-sm table-striped table-bordered table-hover">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Tanggal Rencana</th>
									<th class="text-center text-nowrap">Ruang Lingkup</th>
									<th class="text-center text-nowrap">Tim Auditor</th>
									<th class="text-center text-nowrap">Ketua Auditee</th>
									<th class="text-center text-nowrap">Total Rencana Audit</th>
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
										<td class="text-center">
											{{ $item->auditors_count }}
										</td>
										<td>
											@if ($item->auditee)
												{{$item->auditee->name}}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td class="text-center">
											{{ $item->rencana_audits_count ?: 0 }}
										</td>
										<td class="text-right d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											<a class="btn btn-primary btn-xs text-nowrap"
											   href="{{ route('admin.rencana-audit.riwayat-audit.show', [$unitKerja->id, $item->id]) }}#rencana-audits-table">
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

		@if (request()->routeIs('admin.rencana-audit.riwayat-audit.show'))
			<div class="row">
				<section class="col">
					<!-- Default box -->
					<div class="card" id="rencana-audits">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar Rencana Audit Unit</h3>

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
							@if (request()->routeIs('admin.rencana-audit.riwayat-audit.show') && session()->has('status') && session()->has('message'))
								<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
									<span>{{session()->get('message')}}</span>
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
											<td class="text-bold">Tanggal Perencanaan</td>
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
													{{ ' : ' . $riwayatAudit->unit_kerja->nama }}
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
													@if ($riwayatAudit->auditee)
														{{$riwayatAudit->auditee->name}}
													@else
														-
													@endif
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
		                        {{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
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
									<a href="{{ route('admin.rencana-audit.create', [$unitKerja->id, $riwayatAudit->id]) }}"
									   class="btn btn-primary">
										<i class="mr-2 fas fa-plus"></i>Rencana Audit
									</a>
									<a href="{{ route('admin.rencana-audit.pdf', [$unitKerja->id, $riwayatAudit->id]) }}"
									   class="btn btn-primary">
										<i class="mr-2 fas fa-file"></i>PDF
									</a>
								</div>
							</div>

							<table id="rencana-audits-table" style="width: 100%"
							       class="table table-sm table-bordered table-hover">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Standar Kriteria</th>
									<th class="text-center text-nowrap">Sub Unit Kerja</th>
									<th class="text-center text-nowrap">Auditor</th>
									<th class="text-center text-nowrap">Auditee</th>
									<th class="text-center text-nowrap">Dokumen</th>
									<th class="text-center text-nowrap">Aksi</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($rencanaAudits as $item)
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td>
											@if ($item->standarKriteria)
												{{$item->standarKriteria->nama}}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td>{{ $item->sub_unit_kerja }}</td>
										<td>
											@if ($item->auditor)
												{{$item->auditor->name}}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td>
											@if ($item->auditee)
												{{$item->auditee->name}}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td>{{ $item->dokumen }}</td>
										<td class="text-right d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											<a class="btn btn-warning btn-xs text-nowrap"
											   href="{{ route('admin.rencana-audit.edit', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}">
												<i class="mr-2 fas fa-pencil-alt"></i>Edit
											</a>
											<a class="btn btn-danger btn-xs text-nowrap rencana-audit-delete-btn"
                         data-rencana-audit-id="{{$item->id}}"
											   href="{{ route('admin.rencana-audit.destroy', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}"
											><i class="mr-2 fas fa-trash"></i>Delete
											</a>
											<form id="rencana-audit-delete-form-{{ $item->id }}" class="d-none" method="POST"
											      action="{{ route('admin.rencana-audit.destroy', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}">
												@csrf
												@method("DELETE")
											</form>
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
	</div>
@endsection

@section('sidebar')
	@include('admin.sidebar')
@endsection

@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
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

          /*Delete Unit Kerja*/
          $('#rencana-audits .rencana-audit-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Rencana Audit ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $(`#rencana-audit-delete-form-${$($el).data().rencanaAuditId}`).submit()
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

          $('#riwayat-rencana-audit-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });

          $('#rencana-audits-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });
          /*Datatables*/
      });
	</script>
@endsection
