@section('sidebar')
	<!-- Sidebar user panel (optional) -->
	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
			<img src="{{ auth()->user()->profile_photo_url }}" class="img-circle elevation-2"
			     alt="{{ auth()->user()->name }}">
		</div>
		<div class="info">
			<a href="#" class="d-block">{{ auth()->user()->name }}</a>
		</div>
	</div>

	<!-- SidebarSearch Form -->
	<div class="form-inline">
		<div class="input-group" data-widget="sidebar-search">
			<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
			<div class="input-group-append">
				<button class="btn btn-sidebar">
					<i class="fas fa-search fa-fw"></i>
				</button>
			</div>
		</div>
	</div>

	<!-- Sidebar Menu -->
	<nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<!-- Add icons to the links using the .nav-icon class
					 with font-awesome or any other icon font library -->
			<li class="nav-item">
				<a href="{{ route('auditor.dashboard') }}"
				   class="nav-link {{ request()->routeIs('auditor.dashboard*') ? 'active' : '' }}">
					<i class="nav-icon fas fa-columns"></i>
					<p>Dashboard</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('auditor.rencana-audit.indexUnitKerja') }}"
				   class="nav-link {{ request()->routeIs('auditor.rencana-audit*') ? 'active' : '' }}"
				>
					<i class="nav-icon fas fa-inbox"></i>
					<p>Rencana Audit</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('auditor.checklist-audit.indexUnitKerja') }}"
				   class="nav-link {{ request()->routeIs('auditor.checklist-audit*') ? 'active' : '' }}"
				>
					<i class="nav-icon fas fa-sticky-note"></i>
					<p>Checklist Audit</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('auditor.ptk.indexUnitKerja') }}"
				   class="nav-link {{ request()->routeIs('auditor.ptk*') ? 'active' : '' }}"
				>
					<i class="nav-icon fas fa-house-damage"></i>
					<p>PTK/OAI</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('auditor.berita-acara.indexUnitKerja') }}"
				   class="nav-link {{ request()->routeIs('auditor.berita-acara*') ? 'active' : '' }}"
				>
					<i class="nav-icon fas fa-book"></i>
					<p>Berita Acara</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('auditor.attendance.indexUnitKerja') }}"
				   class="nav-link {{ request()->routeIs('auditor.attendance*') ? 'active' : '' }}"
				>
					<i class="nav-icon fas fa-address-book"></i>
					<p>Kehadiran</p>
				</a>
			</li>
			<li class="nav-item">
				<a onclick="event.preventDefault();document.getElementById('form-logout').submit()"
				   href="{{ route('auditor.logout') }}"
				   class="nav-link"
				><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p>
				</a>
				<form method="POST" id="form-logout"
				      action="{{ route('auditor.logout') }}"
				      class="d-none"
				>@csrf</form>
			</li>
		</ul>
	</nav>
	<!-- /.sidebar-menu -->
@endsection
