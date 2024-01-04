@section('sidebar')
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ auth()->user()->profile_photo_url }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
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
        <a href="{{ route('auditee.dashboard') }}" class="nav-link {{ request()->routeIs('auditee.dashboard') ? 'active' : '' }}">
          <i class="nav-icon fas fa-columns"></i>
          <p>Dashboard</p>
        </a>
      </li>
	    <li class="nav-item">
		    <a href="{{ route('auditee.rencana-audit.riwayat-audit.index') }}"
		       class="nav-link {{ request()->routeIs('auditee.rencana-audit*') ? 'active' : '' }}"
		    >
			    <i class="nav-icon fas fa-inbox"></i>
			    <p>Rencana Audit</p>
		    </a>
	    </li>
	    <li class="nav-item">
		    <a href="{{ route('auditee.ptk.riwayat-audit.index') }}"
		       class="nav-link {{ request()->routeIs('auditee.ptk*') ? 'active' : '' }}"
		    >
			    <i class="nav-icon fas fa-house-damage"></i>
			    <p>PTK/OAI</p>
		    </a>
	    </li>
	    <li class="nav-item">
		    <a href="{{ route('auditee.berita-acara.indexRiwayat') }}"
		       class="nav-link {{ request()->routeIs('auditee.berita-acara*') ? 'active' : '' }}"
		    >
			    <i class="nav-icon fas fa-book"></i>
			    <p>Berita Acara</p>
		    </a>
	    </li>
	    <li class="nav-item">
		    <a href="{{ route('auditee.attendance.riwayat-audit.index') }}"
		       class="nav-link {{ request()->routeIs('auditee.attendance*') ? 'active' : '' }}"
		    >
			    <i class="nav-icon fas fa-address-book"></i>
			    <p>Kehadiran</p>
		    </a>
	    </li>
      <li class="nav-item">
        <a href="{{ route('auditee.logout') }}"
           onclick="event.preventDefault();document.getElementById('form-logout').submit()"
           class="nav-link">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>Logout</p>
        </a>
        <form
          action="{{ route('auditee.logout') }}"
          method="POST" id="form-logout"
          class="d-none">@csrf</form>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
@endsection
