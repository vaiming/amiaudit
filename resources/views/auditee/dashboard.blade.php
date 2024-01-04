@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
	      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Fonts -->
	<link rel="dns-prefetch"
        href="//fonts.gstatic.com">
	<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito">
	<!-- Font Awesome -->
	<link rel="stylesheet"
        href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet"
        href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet"
        href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet"
        href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
@endsection

@section('content-header')
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col">
				<ol class="text-sm breadcrumb float-sm-right">
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Dashboard</h1>
			</div>
		</div>
	</div>
@endsection

@section('main-content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="small-box bg-teal">
					<div class="inner">
						<h2 class="text-bold">{{ $unitKerja->nama }}</h2>
						<h5 class="text-bold">Unit Kerja</h5>
					</div>
					<div class="icon">
						<i class="ion ion-home"></i>
					</div>
					<a href="#unitKerja" class="small-box-footer"
					>More info<i class="mx-2 fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="small-box bg-cyan">
					<div class="inner">
						<h2 class="text-bold">{{ $standarKriterias->count() }}</h2>
						<h5 class="text-bold">Standar Kriteria</h5>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
					<a href="#standar-kriteria" class="small-box-footer"
					>More info<i class="mx-2 fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="row">
			<section class="col-xl-6">
				<div class="card" id="standar-kriteria" style="min-height: 950px">
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
						<div class="table-data table-responsive p-0" style="max-height: 800px">
							<table class="table table-sm table-bordered table table-head-fixed table-hover">
								<thead class="thead-light">
								<tr>
									<th class="text-center text-nowrap">No</th>
									<th class="text-center text-nowrap">Kategori</th>
									<th class="text-center text-nowrap">Nama</th>
									<th class="text-center">Total Pernyataan</th>
									<th class="text-center">Total Measure</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($standarKriterias as $sk)
									@php
										$pernyataans = $sk->pernyataanStandars->intersect($pernyataansUnitKerja->pluck('pernyataan_standar'));
										$measures = $sk->measures->intersect($pernyataansUnitKerja->where('standar_kriteria_id', $sk->id)->pluck('measures')->flatten(1));
									@endphp
									<tr data-widget="expandable-table" aria-expanded="false">
										<td class="text-center">{{ $loop->iteration }}</td>
										<td>{{ $sk->kategori }}</td>
										<td>{{ $sk->nama }}</td>
										<td class="text-center">{{ $pernyataans->count() }}</td>
										<td class="text-center">{{ $measures->count() }}</td>
									</tr>
									<tr class="expandable-body d-none">
										<td colspan="6">
											<h6 class="card-header">Detail Standar Kriteria</h6>
											<ul class="pl-4">
												@foreach ($pernyataans as $pernyataan)
													<li>{{ $pernyataan->pernyataan_standar }}</li>
													<div class="text-bold mt-2">Measure-measure :</div>
													@if ($measures->where('pernyataan_standar_id', $pernyataan->id)->isNotEmpty())
														<ul class="pl-4">
															@foreach ($measures->where('pernyataan_standar_id', $pernyataan->id) as $measureItem)
																<li>
																	{{ $measureItem->measure }}
																</li>
															@endforeach
														</ul>
													@else
														<div class="font-weight-light font-italic">Tidak ada measure!</div>
													@endif
													<hr/>
												@endforeach
											</ul>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>

			<section class="col-xl-6">
			</section>
		</div>
	</div>
@endsection

@section('sidebar')
	@include('auditee.sidebar')
@endsection


@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
      $.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- overlayScrollbars -->
	<script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
@endsection
