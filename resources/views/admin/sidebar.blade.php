@section('sidebar')
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ auth()->user()->profile_photo_url }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
    </div>
    <div class="info">
      <a href="{{request()->root()}}" class="d-block">{{ auth()->user()->name }}</a>
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
      <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}"
        >
          <i class="nav-icon fas fa-columns"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.riwayat-audit.indexUnitKerja') }}"
           class="nav-link {{ request()->routeIs('admin.riwayat-audit*') ? 'active' : '' }}"
        >
          <i class="nav-icon fas fa-history"></i>
          <p>Riwayat Audit</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.rencana-audit.indexUnitKerja') }}"
           class="nav-link {{ request()->routeIs('admin.rencana-audit*') ? 'active' : '' }}"
        >
          <i class="nav-icon fas fa-inbox"></i>
          <p>Rencana Audit</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.checklist-audit.indexUnitKerja') }}"
           class="nav-link {{ request()->routeIs('admin.checklist-audit*') ? 'active' : '' }}"
        >
	        <i class="nav-icon fas fa-sticky-note"></i>
          <p>Checklist Audit</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.ptk.indexUnitKerja') }}"
           class="nav-link {{ request()->routeIs('admin.ptk*') ? 'active' : '' }}"
        >
          <i class="nav-icon fas fa-house-damage"></i>
          <p>PTK/OAI</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.berita-acara.indexUnitKerja') }}"
           class="nav-link {{ request()->routeIs('admin.berita-acara*') ? 'active' : '' }}"
        >
          <i class="nav-icon fas fa-book"></i>
          <p>Berita Acara</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.attendance.indexUnitKerja') }}"
           class="nav-link {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}"
        >
          <i class="nav-icon fas fa-address-book"></i>
          <p>Kehadiran</p>
        </a>
      </li>
	    <li class="nav-item">
		    <a href="{{ route('admin.users.index') }}"
		       class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
		    >
			    <i class="nav-icon fas fa-user-friends"></i>
			    <p>Pengelolaan Pengguna</p>
		    </a>
	    </li>

      <li class="nav-item">
	      <a onclick="event.preventDefault();document.getElementById('form-logout').submit()"
	         href="{{ route('admin.logout') }}" class="nav-link"
	      ><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p>
	      </a>
	      <form action="{{ route('admin.logout') }}" method="POST"
	            id="form-logout" class="d-none"
	      >@csrf
	      </form>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
@endsection
