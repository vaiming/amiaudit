@extends('layouts.app')

@section('title', 'Daftar Kehadiran Unit')

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
					@if (request()->routeIs('admin.attendance.indexUnitKerja'))
						<li class="breadcrumb-item active">{{__('Beranda')}}</li>
					@elseif (request()->routeIs('admin.attendance.riwayat-audit.index') || request()->routeIs('admin.attendance.riwayat-audit.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.attendance.indexUnitKerja') }}">
								{{__('Beranda')}}
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.attendance.riwayat-audit.index'))
						<li class="breadcrumb-item active">Daftar Riwayat Kehadiran - {{ $unitKerja->nama }}</li>
					@elseif (request()->routeIs('admin.attendance.riwayat-audit.show'))
						<li class="text-sm breadcrumb-item">
							<a href="{{ route('admin.attendance.riwayat-audit.index', [$unitKerja->id]) }}">
								Daftar Riwayat Kehadiran - {{ $unitKerja->nama }}
							</a>
						</li>
					@endif
					@if (request()->routeIs('admin.attendance.riwayat-audit.show'))
						<li class="breadcrumb-item active">Daftar Kehadiran</li>
					@endif
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Kehadiran Unit</h1>
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
						@if (request()->routeIs('admin.attendance.indexUnitKerja') && session()->has('status') && session()->has('message'))
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
								<th class="text-center text-nowrap">Total Riwayat Kehadiran</th>
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
										   href="{{ route('admin.attendance.riwayat-audit.index', [$item->id]) }}#riwayat-attendance">
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

		@if (request()->routeIs('admin.attendance.riwayat-audit.index') || request()->routeIs('admin.attendance.riwayat-audit.show'))
			<div class="row">
				<section class="col">
					<div class="card" id="riwayat-attendance">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar Riwayat Kehadiran</h3>

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
							@if (request()->routeIs('admin.attendance.riwayat-audit.index') && session()->has('status') && session()->has('message'))
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

							<table id="riwayat-attendance-table" style="width: 100%"
							       class="table table-sm table-striped table-bordered table-hover">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Tanggal Rencana</th>
									<th class="text-center text-nowrap">Ruang Lingkup</th>
									<th class="text-center text-nowrap">Tim Auditor</th>
									<th class="text-center text-nowrap">Ketua Auditee</th>
									<th class="text-center text-nowrap">Total Kehadiran</th>
									<th class="text-center text-nowrap">Aksi</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($riwayatAudits as $item)
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">
											{{ parse_date_to_iso_format($item->tanggal_rencana) }}
										</td>
										<td class="text-center">
											{{ $item->ruang_lingkup_id ? $item->ruang_lingkup->getRuangLingkupFormat() : '-' }}
										</td>
										<td class="text-center">
											{{ $item->auditors_count }}
										</td>
										<td>
											@if ($item->auditee)
												{{ $item->auditee->name }}
											@else
												<div class="text-center">-</div>
											@endif
										</td>
										<td class="text-center">
											{{ $item->attendances_count ?: 0 }}
										</td>
										<td class="text-right d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											<a class="btn btn-primary btn-xs text-nowrap"
											   href="{{ route('admin.attendance.riwayat-audit.show', [$unitKerja->id, $item->id]) }}#attendances">
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

		@if (request()->routeIs('admin.attendance.riwayat-audit.show'))
			<div class="row">
				<section class="col">
					<div class="card" id="attendances">
						<div class="card-header bg-gradient-lightblue">
							<h3 class="card-title">Daftar Kehadiran Unit</h3>

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
							@if (request()->routeIs('admin.attendance.riwayat-audit.show') && session()->has('status') && session()->has('message'))
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
														{{ $riwayatAudit->auditee->name}}
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
									<button type="button" class="btn btn-primary"
									        data-backdrop="static" data-toggle="modal"
									        data-target="#create-attendance"
									><i class="mr-2 fas fa-plus"></i>Kehadiran</button>
									<a href="{{ route('admin.attendance.pdf', [$unitKerja->id, $riwayatAudit->id]) }}"
									   class="btn btn-primary">
										<i class="mr-2 fas fa-file"></i>PDF
									</a>

									{{-- Add attendance --}}
									<div class="modal fade" id="create-attendance">
										<div class="modal-dialog">
											<form
													action="{{ route('admin.attendance.store', [$unitKerja->id, $riwayatAudit->id]) }}"
													method="POST" class="modal-content d-block">
												@csrf
												<div class="modal-header">
													<h4 class="modal-title">Tambah Nama Kehadiran</h4>
													<button type="button" class="close"
													        data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													@if($errors->store_attendance->any())
														<div class="alert alert-warning alert-dismissible fade show" role="alert">
															<h6>Pesan Error:</h6>
															<ul class="mb-0 pl-4">
																@foreach ($errors->store_attendance->all() as $error)
																	<li>{{ $error }}</li>
																@endforeach
															</ul>
															<button type="button" class="close" data-dismiss="alert"
															        aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
													@endif

													<div class="form-group">
														<label class="col-form-label" for="name">Nama</label>
														<input
																type="text" id="name" name="name"
																value="{{ old('name') }}"
																class="form-control @error('name', 'store_attendance') is-invalid @enderror"
																autofocus
														>
														@error('name', 'store_attendance')
														<div class="invalid-feedback text-danger d-block">
															{{ $message }}
														</div>
														@enderror
													</div>

													<div class="form-group">
														<label class="col-form-label" for="origin">Departemen/Fakultas/Unit</label>
														<input
																type="text" id="origin" name="origin"
																value="{{ old('origin') }}"
																class="form-control @error('origin', 'store_attendance') is-invalid @enderror"
														>
														@error('origin', 'store_attendance')
														<div class="invalid-feedback text-danger d-block">
															{{ $message }}
														</div>
														@enderror
													</div>
												</div>

												<div class="modal-footer justify-content-end">
													<button type="button" class="btn btn-default text-uppercase" data-dismiss="modal"
													>Close</button>
													<button type="submit" class="btn btn-primary text-uppercase"
													>Submit</button>
												</div>
											</form>
										</div>
									</div>
                  <script>
                      window.addEventListener('DOMContentLoaded', (event) => {
                          const isCreateModalShow = "{{$errors->store_attendance->any()}}".length > 0;
                          $('#create-attendance').modal({
                              show: isCreateModalShow
                          });
                      });
                  </script>
                  {{-- Akhir modal --}}
								</div>
							</div>

							<table id="attendances-table" style="width: 100%"
							       class="table table-sm table-bordered table-hover">
								<thead>
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Nama</th>
									<th class="text-center text-nowrap">Departemen/Fakultas/Unit</th>
									<th class="text-center text-nowrap">Aksi</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($attendances as $item)
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td>{{ $item->name }}</td>
										<td>{{ $item->origin }}</td>
										<td class="d-flex justify-content-center align-items-center flex-wrap"
										    style="gap: 0.5rem">
											<button type="button" class="btn btn-warning btn-xs text-nowrap"
											        data-backdrop="static" data-toggle="modal"
											        data-target="#edit-attendance-{{ $item->id}}"
											><i class="mr-2 fas fa-pencil-alt"></i>Edit</button>

											{{-- Edit attendance --}}
											<div class="modal fade" id="edit-attendance-{{ $item->id}}">
												<div class="modal-dialog">
													<form
															action="{{ route('admin.attendance.update', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}"
															method="POST" class="modal-content d-block">
														@csrf
														@method('PUT')
														<div class="modal-header">
															<h4 class="modal-title">Edit Nama Kehadiran</h4>
															<button type="button" class="close"
															        data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															@if($errors->error_key->first() === "update_attendance_$item->id" && $errors->update_attendance->any())
																<div class="alert alert-warning alert-dismissible fade show" role="alert">
																	<h6>Pesan Error:</h6>
																	<ul class="mb-0 pl-4">
																		@foreach ($errors->update_attendance->all() as $error)
																			<li>{{ $error }}</li>
																		@endforeach
																	</ul>
																	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
															@endif

															<div class="form-group">
																<label class="col-form-label" for="name">Nama</label>
																<input
																		type="text" id="name" name="name"
																		value="{{ old('name', $item->name) }}"
																		class="form-control"
																		autofocus
																>
																@error('name', 'update_attendance')
                                @if ($errors->error_key->first() === "update_attendance_$item->id")
                                  <div class="invalid-feedback text-danger d-block">
                                    {{ $message }}
                                  </div>
                                @endif
                                @enderror
															</div>

															<div class="form-group">
																<label class="col-form-label" for="origin">Departemen/Fakultas/Unit</label>
																<input
																		type="text" id="origin" name="origin"
																		value="{{ old('origin', $item->origin) }}"
																		class="form-control"
																>
																@error('origin', 'update_attendance')
                                @if ($errors->error_key->first() === "update_attendance_$item->id")
                                  <div class="invalid-feedback text-danger d-block">
                                    {{ $message }}
                                  </div>
                                @endif
																@enderror
															</div>
														</div>

														<div class="modal-footer justify-content-end">
															<button type="button" data-dismiss="modal"
															        class="btn btn-default text-uppercase"
															>Close</button>
															<button type="submit" class="btn btn-primary text-uppercase"
															>Submit</button>
														</div>
													</form>
												</div>
											</div>
                      <script>
                          window.addEventListener('DOMContentLoaded', (event) => {
                              const isEditModalShow = "{{$errors->error_key->first() === "update_attendance_$item->id"}}".length > 0;
                              $("#edit-attendance-{{$item->id}}").modal({
                                  show: isEditModalShow
                              });
                              if (isEditModalShow) {
                                  if ("{{$errors->update_attendance->has('name')}}".length > 0){
                                      $("#edit-attendance-{{ $item->id}} #name").addClass('is-invalid');
                                  }
                                  if ("{{$errors->update_attendance->has('origin')}}".length > 0){
                                      $("#edit-attendance-{{ $item->id}} #origin").addClass('is-invalid');
                                  }
                              }
                          });
                      </script>
                      {{--Akhir Modal--}}

											<a class="btn btn-danger btn-xs text-nowrap attendance-delete-btn"
                         data-attendance-id="{{ $item->id }}"
                         data-name="{{ $item->name }}"
											   href="{{ route('admin.attendance.destroy', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}"
											><i class="mr-2 fas fa-trash"></i>Delete
											</a>
											<form id="attendance-delete-form-{{ $item->id }}" class="d-none" method="POST"
											      action="{{ route('admin.attendance.destroy', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}">
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
          $('#attendances .attendance-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: `Kehadiran ${$($el).data().name} akan dihapus!`,
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $(`#attendance-delete-form-${$($el).data().attendanceId}`).submit()
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

          $('#riwayat-attendance-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });

          $('#attendances-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });
          /*Datatables*/

      });
	</script>
@endsection
