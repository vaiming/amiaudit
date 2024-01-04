@extends('layouts.app')

@section('title', 'Daftar Riwayat Audit')

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
					@if (request()->routeIs('admin.riwayat-audit.indexUnitKerja'))
						<li class="breadcrumb-item active">{{__('Beranda')}}</li>
					@elseif (request()->routeIs('admin.riwayat-audit.index') || request()->routeIs('admin.riwayat-audit.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.riwayat-audit.indexUnitKerja') }}">
								{{__('Beranda')}}
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.riwayat-audit.index'))
						<li class="breadcrumb-item active">Daftar Riwayat Audit - {{ $unitKerja->nama }}</li>
					@elseif (request()->routeIs('admin.riwayat-audit.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.riwayat-audit.index', [$unitKerja->id]) }}">
								Daftar Riwayat Audit - {{ $unitKerja->nama }}
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.riwayat-audit.show'))
						<li class="breadcrumb-item active">Detail Riwayat Audit</li>
					@endif
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Riwayat Audit</h1>
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
						@if (request()->routeIs('admin.riwayat-audit.indexUnitKerja') && session()->has('status') && session()->has('message'))
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
								<th class="text-center text-nowrap">Total Riwayat Audit</th>
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
										   href="{{ route('admin.riwayat-audit.index', [$item->id]) }}#riwayat-audits">
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

		@if (request()->routeIs('admin.riwayat-audit.index') || request()->routeIs('admin.riwayat-audit.show'))
			<div class="row">
				<section class="col">
					<div class="card" id="riwayat-audits">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar Riwayat Audit</h3>

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
							@if (request()->routeIs('admin.riwayat-audit.index') && session()->has('status') && session()->has('message'))
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
								<div class="">
									<a href="{{ route('admin.riwayat-audit.create', [$unitKerja->id]) }}"
									   class="btn btn-primary">
										<i class="mr-2 fas fa-plus"></i>Riwayat Audit
									</a>
								</div>
							</div>

							<table id="riwayat-audit-table" style="width: 100%"
							       class="table table-sm table-striped table-bordered table-hover">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Tanggal Rencana</th>
									<th class="text-center text-nowrap">Ruang Lingkup</th>
									<th class="text-center text-nowrap">Tim Auditor</th>
									<th class="text-center text-nowrap">Ketua Auditee</th>
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
												{{$item->auditee->name}}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td class="text-right d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											<a class="btn btn-primary btn-xs text-nowrap"
											   href="{{ route('admin.riwayat-audit.show', [$unitKerja->id, $item->id]) }}#detail-riwayat-audit">
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

		@if (request()->routeIs('admin.riwayat-audit.show'))
			<div class="row">
				<section class="col-xl-8 col-lg-9 col-md-10 col-sm-11 col-12">
					<!-- Default box -->
					<div class="card" id="detail-riwayat-audit">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Detail Riwayat Audit</h3>

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
							@if (request()->routeIs('admin.riwayat-audit.show') && session()->has('status') && session()->has('message'))
								<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
									<span>{{session()->get('message')}}</span>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif

							<div class="d-flex flex-row justify-content-between">
								<div class="mb-4 d-flex flex-column justify-content-end">
									<table>
										<tbody>
										<tr>
											<td colspan="2">
												<h2 class="text-lg p-0 m-0">Data Riwayat Audit</h2>
												<small class="block text-muted">Data dibawah ini digunakan sebagai pembeda riwayat dari rencana audit, checklist audit, dsb.</small>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Tanggal Perencanaan</td>
											<td>
												{{ ' : ' . parse_date_to_iso_format($riwayatAudit->tanggal_rencana) }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Unit Kerja</td>
											<td>
												{{ ' : ' . $riwayatAudit->unit_kerja->nama }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Tim Auditor</td>
											<td>
												{{ ' : ' }}
												@if ($riwayatAudit->auditors->isNotEmpty())
													{{ $riwayatAudit->auditors->pluck('name')->join(', ', ', dan ') }}
												@else
													-
												@endif
											</td>
										</tr>
										<tr>
											<td class="text-bold">Ketua Auditee</td>
											<td>
												{{ ' : ' }}
												@if ($riwayatAudit->auditee)
													{{$riwayatAudit->auditee->name}}
												@else
													-
												@endif
											</td>
										</tr>
										<tr>
											<td class="text-bold">Lokasi</td>
											<td>
												{{ ' : ' . $riwayatAudit->lokasi }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Ruang Lingkup</td>
											<td>
												{{ ' : ' }}
												@if ($riwayatAudit->ruang_lingkup_id)
													{{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
												@else
													-
												@endif
											</td>
										</tr>


										<tr>
											<td colspan="2" class="pt-4">
												<h2 class="text-lg p-0 m-0">Data Untuk Dokumen Cetak</h2>
												<small class="block text-muted">Data dibawah ini digunakan untuk mengisi data pada tampilan cetak dokumen</small>
											</td>
										</tr>
										<tr>
											<td class="text-bold">Nomor Dokumen</td>
											<td>
												{{ ' : ' . $riwayatAudit->nomor_dokumen }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Status Revisi</td>
											<td>
												{{ ' : ' . $riwayatAudit->status_revisi }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Tanggal Pembuatan</td>
											<td>
												{{ ' : ' . parse_date_to_iso_format($riwayatAudit->tanggal_pembuatan) }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Halaman</td>
											<td>
												{{ ' : ' . $riwayatAudit->halaman }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Ketua Tim Auditor</td>
											<td>
												{{ ' : ' . $riwayatAudit->ketua_tim_auditor }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Kaur SAI</td>
											<td>
												{{ ' : ' . $riwayatAudit->kaur_sai }}
											</td>
										</tr>
										<tr>
											<td class="text-bold">Kabag Sekpim, Legal dan Internal Audit</td>
											<td>
												{{ ' : ' . $riwayatAudit->kabag_sekpim_legal_audit }}
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="d-flex justify-content-center align-items-center" style="gap: .25rem">
								<a class="btn btn-warning btn-sm text-nowrap"
								   href="{{ route('admin.riwayat-audit.edit', [$unitKerja->id, $riwayatAudit->id]) }}">
									<i class="mr-2 fas fa-pencil-alt"></i>Edit
								</a>
								<a class="btn btn-danger btn-sm text-nowrap riwayat-audit-delete-btn"
								   data-riwayat-audit-id="{{$riwayatAudit->id}}"
								   data-rencana-audit-count="{{$riwayatAudit->rencana_audits_count}}"
								   data-checklist-audit-count="{{$riwayatAudit->checklist_audits_count}}"
								   data-ptk-count="{{$riwayatAudit->ptks_count}}"
								   data-attendance-count="{{$riwayatAudit->attendances_count}}"
								   href="{{ route('admin.riwayat-audit.destroy', [$unitKerja->id, $riwayatAudit->id]) }}"
								><i class="mr-2 fas fa-trash"></i>Delete
								</a>
								<form id="riwayat-audit-delete-form-{{ $riwayatAudit->id }}" class="d-none" method="POST"
								      action="{{ route('admin.riwayat-audit.destroy', [$unitKerja->id, $riwayatAudit->id]) }}">
									@csrf
									@method("DELETE")
								</form>
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

          /*Delete Riwayat Audit*/
          $('#detail-riwayat-audit .riwayat-audit-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Riwayat Audit ini akan dihapus!",
                  }).then((result) => {
                      const isDeleteSafe =
                          parseInt($($el).data().rencanaAuditCount) > 0 ||
                          parseInt($($el).data().checklistAuditCount) > 0 ||
                          parseInt($($el).data().ptkCount) > 0 ||
                          parseInt($($el).data().attendanceCount) > 0;
                      console.log(isDeleteSafe)

                      if (result.isConfirmed && isDeleteSafe > 0) {
                          AlertSwal2.fire({
                              icon: 'error',
                              title: 'Gagal Menghapus',
                              text: "Maaf, Anda tidak bisa menghapus riwayat audit ini karena terdapat data-data audit.\n" +
                                  "Jika ingin menghapusnya, anda perlu mengosongkan data audit pada riwayat ini terlebih dahulu.",
                          });
                      } else if (result.isConfirmed) {
                          $(`#riwayat-audit-delete-form-${$($el).data().riwayatAuditId}`).submit()
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

          $('#riwayat-audit-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });
          /*Datatables*/
      });
	</script>
@endsection
