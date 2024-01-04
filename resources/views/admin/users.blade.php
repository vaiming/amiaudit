@extends('layouts.app')

@section('title', 'Pengelolaan User')

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
	<!-- Select2 -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
@endsection

@section('content-header')
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col">
				<ol class="text-sm breadcrumb float-sm-right">
					<li class="breadcrumb-item active">Pengelolaan Pengguna</li>
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Pengelolaan Pengguna</h1>
			</div>
			</div>
	</div>
@endsection

@section('main-content')
	<div class="container-fluid">
		<div class="row">
			<section class="col">
				<div class="card" id="users">
					<div class="card-header bg-gradient-lightblue">
						<h3 class="card-title">Daftar Pengguna</h3>

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
						@if (session()->has('status') && session()->has('message'))
							<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
								<span>{!! session()->get('message') !!}</span>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@endif

						<div class="mb-4 d-flex flex-row justify-content-end">
							<a href="{{ route('admin.users.create') }}#tambah-user" class="btn btn-primary text-capitalize">
								<i class="mr-2 fas fa-plus"></i>Pengguna
							</a>
						</div>

						<table id="users-table" class="table table-sm table-bordered table-hover"
						       style="width: 100%"
						>
							<thead>
							<tr>
								<th class="text-center text-nowrap">No</th>
								<th class="text-center text-nowrap">Nama</th>
								<th class="text-center text-nowrap">Username</th>
								<th class="text-center text-nowrap">Email</th>
								<th class="text-center text-nowrap">Peran</th>
								<th class="text-center text-nowrap">Unit Kerja</th>
								<th class="text-center text-nowrap">Dibuat Pada</th>
								<th class="text-center text-nowrap">Aksi</th>
							</tr>
							</thead>
							<tbody id="table-body">
							@foreach($users as $item)
								<tr>
									<td class="text-center">{{ $loop->iteration }}</td>
									<td class="text-nowrap">{{ $item->name }}</td>
									<td class="text-nowrap">{{ $item->username }}</td>
									<td class="text-nowrap">{{ $item->email }}</td>
									<td>{{ \Str::ucfirst($item->role_name) }}</td>
									<td class="text-nowrap">
										@if ($item->unitKerja)
											{{$item->unitKerja->nama}}
										@else
											<div class="text-center">-</div>
										@endif
									</td>
									<td class="text-center text-nowrap">{{ $item->created_at}}</td>
									<td class="text-right d-flex flex-nowrap justify-content-center align-items-center flex-wrap" style="gap: 0.5rem">
										<a class="text-nowrap btn btn-warning btn-xs"
                       href="{{ route('admin.users.edit', [$item->username]) }}#edit-user"
										><i class="mr-2 fas fa-pencil-alt"></i>Edit</a>
										<a class="text-nowrap btn btn-danger btn-xs user-delete-btn"
										   href="{{ route('admin.users.destroy', [$item->username]) }}"
                       data-name="{{$item->name}}"
                       data-username="{{$item->username}}"
                       data-riwayat-audits-count="{{$item->riwayat_audits_count}}"
										><i class="mr-2 fas fa-trash"></i>Delete</a>
										<form id="user-delete-form-{{$item->username}}" class="d-none" method="POST"
													action="{{ route('admin.users.destroy', [$item->username]) }}"
                    >
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

		<!-- Create User -->
		@if (request()->routeIs('admin.users.create'))
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-6">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title" id="tambah-user">Membuat Akun Pengguna</h3>

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
							<form action="{{ route('admin.users.store') }}" method="POST">
								@csrf
								<div class="form-group">
									<label class="col-form-label" for="name">Nama</label>
									<input type="text" id="name" name="name" value="{{ old('name') }}"
                         class="form-control @error('name') is-invalid @enderror"
                  />
									@error('name')
									<div class="invalid-feedback text-danger d-block">
										{{ $message }}
									</div>
									@enderror
								</div>

								{{--Username & Email--}}
								<div class="form-group">
									<div class="row">
										<div class="col-md-12 col-lg-6">
											<label class="col-form-label" for="username">Username</label>
											<input type="text" id="username" name="username" value="{{ old('username') }}"
                             class="form-control @error('username') is-invalid @enderror"
                      />
											@error('username')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
										<div class="col-md-12 col-lg-6">
											<label class="col-form-label" for="email">E-Mail</label>
											<input
													type="email" id="email" name="email" value="{{ old('email') }}"
													class="form-control @error('email') is-invalid @enderror"
                      />
											@error('email')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
								</div>

								{{--Password & CPassword--}}
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12 col-md-6">
											<label class="col-form-label" for="password">Password</label>
											<input type="password" id="password" name="password"
                             class="form-control @error('password') is-invalid @enderror"
                      />
											@error('password')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
										<div class="col-sm-12 col-md-6">
											<label class="col-form-label" for="cpassword">Confirm Password</label>
											<input type="password" id="cpassword" name="cpassword"
                             class="form-control @error('cpassword') is-invalid @enderror"
                      />
											@error('cpassword')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
								</div>

								{{--Position & Hak akses--}}
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-form-label" for="unit_kerja_id">Unit Kerja</label>
											<select id="unit_kerja_id" name="unit_kerja_id"
                              class="form-control select2bs4 @error('unit_kerja_id') is-invalid @enderror"
                              style="width: 100%;"
                      >
												<option selected disabled="disabled" value="">Pilih...</option>
												@foreach($unitKerjas as $item)
													<option {{ old('unit_kerja_id') == $item->id ? 'selected' : '' }}
                                  value="{{ $item->id }}"
                          >{{ $item->nama }}</option>
												@endforeach
											</select>
											@error('unit_kerja_id')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-form-label" for="access">Hak Akses</label>
											<select id="access" name="access"
                              class="form-control select2bs4 @error('access') is-invalid @enderror"
                              style="width: 100%;"
                      >
												<option selected disabled="disabled" value="">Pilih...</option>
												<option {{ old('access') == 'auditor' ? 'selected' : '' }}
                                value="auditor"
                        >Auditor</option>
												<option {{ old('access') == 'auditee' ? 'selected' : '' }}
                                value="auditee"
                        >Auditee</option>
											</select>
											@error('access')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
								</div>

								<div class="card-footer p-0 d-flex justify-content-end" style="gap:.5rem">
									<a href="{{ route('admin.users.index') }}"
									   class="btn btn-danger text-uppercase"
									>Batal</a>
									<button type="submit" class="btn btn-primary text-uppercase">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		@endif

	  <!-- Edit User -->
		@if (request()->routeIs('admin.users.edit'))
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-6">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title" id="edit-user">Edit Akun Pengguna</h3>

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
							<form action="{{ route('admin.users.update', [$userrr->username]) }}" method="POST">
								@csrf
								@method('PATCH')

								<div class="form-group">
									<label class="col-form-label" for="name">Nama</label>
									<input type="text" id="name" name="name" value="{{ old('name', $userrr->name) }}"
                         class="form-control @error('name') is-invalid @enderror"
                  />
									@error('name')
									<div
											class="invalid-feedback text-danger d-block">
										{{ $message }}
									</div>
									@enderror
								</div>

								<!--Username & Email-->
								<div class="form-group">
									<div class="row">
										<div class="col-md-12 col-lg-6">
											<label class="col-form-label" for="username">Username</label>
											<input type="text" id="username" name="username" value="{{ old('username', $userrr->username) }}"
                             class="form-control @error('username') is-invalid @enderror"
                      />
											@error('username')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
										<div class="col-md-12 col-lg-6">
											<label class="col-form-label" for="email">E-Mail</label>
											<input type="email" id="email" name="email" value="{{ old('email', $userrr->email) }}"
                             class="form-control @error('email') is-invalid @enderror"
                      />
											@error('email')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
								</div>

								<!--Password & CPassword-->
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12 col-md-6">
											<label class="col-form-label" for="password">Password</label>
											<input type="password" id="password" name="password"
                             class="form-control @error('password') is-invalid @enderror"
                      />
											@error('password')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
										<div class="col-sm-12 col-md-6">
											<label class="col-form-label" for="cpassword">Confirm Password</label>
											<input type="password" id="cpassword" name="cpassword"
                             class="form-control @error('cpassword') is-invalid @enderror"
                      />
											@error('cpassword')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
								</div>

								<!--Position & Hak akses-->
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6">
											<label class="col-form-label" for="unit_kerja_id">Unit Kerja</label>
											<select id="unit_kerja_id" name="unit_kerja_id"
                              class="form-control select2bs4 @error('unit_kerja_id') is-invalid @enderror"
                              style="width: 100%;"
                      >
												<option selected disabled="disabled" value="">Pilih...</option>
												@foreach($unitKerjas as $item)
													<option
															{{ old('unit_kerja_id', $userrr->unit_kerja_id) == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
														{{ $item->nama }}
													</option>
												@endforeach
											</select>
											@error('unit_kerja_id')
											<div class="invalid-feedback text-danger d-block">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
								</div>

								<div class="card-footer p-0 d-flex justify-content-end" style="gap: .5rem">
									<a href="{{ route('admin.users.index') }}"
									   class="btn btn-danger text-uppercase"
									>Batal</a>
									<button type="submit" class="btn btn-primary text-uppercase">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
	<!-- /.container-fluid -->
@endsection


@section('sidebar')
	@include('admin.sidebar')
@endsection

@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- Select2 -->
	<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
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

          /*Delete Users*/
          $('#users .user-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: `Pengguna bernama ${$($el).data().name} akan dihapus!`,
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if ($($el).data().riwayatAuditsCount > 0) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: "Maaf, Anda tidak bisa menghapus pengguna ini karena pengguna tersebut memiliki riwayat audit.",
                              });
                          } else {
                              $(`#user-delete-form-${$($el).data().username}`).submit()
                          }
                      }
                  })
              });
          });

          //Datatables
          $('#users-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });

          //Initialize Select2 Elements
          $("select.select2bs4").select2({
              theme: 'bootstrap4'
          });
      });
	</script>
@endsection
