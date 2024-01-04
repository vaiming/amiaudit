<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Audit Mutu Internal | Institut Teknologi Telkom Purwokerto">
	<meta name="keywords" content="ami, ittp, it telkom purwokerto">
	<meta name="author" content="Institut Teknologi Telkom Purwokerto">

	<title>@yield('title') | {{ config('app.name') }}</title>

	@yield('styles')
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		@include('layouts.navbar')
	</nav>
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<!-- Brand Logo -->
		<a href="#" class="brand-link">
			<img src="{{ asset('images/icon/Logo ITTP.ico') }}"
			     alt="{{ config('app.name') }}"
			     class="brand-image img-fluid elevation-1"
			     style="opacity: .85; border-radius: 4px">
			<span class="brand-text font-weight-normal">AMI ITTP</span>
		</a>

		<!-- Sidebar -->
		<div class="sidebar">
			@yield('sidebar')
		</div>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			@yield('content-header')
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			@yield('main-content')
		</section>
		<!-- /.content -->
	</div>

	<!-- /.content-wrapper -->
	<footer class="main-footer mt-4">
		@include('layouts.footer')
	</footer>
</div>
<!-- ./wrapper -->

@yield('scripts')
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

</body>
</html>
