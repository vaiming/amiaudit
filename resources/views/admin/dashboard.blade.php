@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
	      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

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
						<h2 class="text-bold">{{ $unitKerjas->count() }}</h2>
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
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="small-box bg-olive">
					<div class="inner">
						<h2 class="text-bold">{{ $sumOfAuditors }}</h2>
						<h5 class="text-bold">Auditor</h5>
					</div>
					<div class="icon">
						<i class="fas fa-user-friends"></i>
					</div>
					<a href="{{ route('admin.users.index') }}" class="small-box-footer"
					>More info<i class="mx-2 fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="small-box bg-warning">
					<div class="inner">
						<h2 class="text-bold">{{ $sumOfAuditees }}</h2>
						<h5 class="text-bold">Auditee</h5>
					</div>
					<div class="icon">
						<i class="fas fa-user-friends"></i>
					</div>
					<a href="{{ route('admin.users.index') }}" class="small-box-footer"
					>More info<i class="mx-2 fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
		</div>

		@if (session()->has('status') && session()->has('message'))
			<div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
				<span>{!!session()->get('message')!!}</span>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span class="text-lg text-white" aria-hidden="true">
						<i class="fas fa-times"></i>
					</span>
				</button>
			</div>
		@endif
    @if($errors->any())
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h6>Pesan Error:</h6>
        <ul class="pl-4 mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <div class="row">
      {{--First Row--}}
      <section class="col-xl-6">
        <!-- tambah unit kerja -->
        @if (request()->routeIs('admin.dashboard.unit-kerja.create'))
          @include('admin.unit-kerja.create')
        @endif

        <!-- edit unit kerja -->
        @if (request()->routeIs('admin.dashboard.unit-kerja.edit'))
          @include('admin.unit-kerja.edit', compact('uk_detail'))
        @endif

        <!-- tambah pernyataan & measure UK -->
        @if (request()->routeIs('admin.dashboard.unit-kerja.indikator.create'))
          @include('admin.unit-kerja.pernyataan-standar.create', compact('unitKerja', 'standarKriterias'))
        @endif

        <!-- Edit pernyataan & measure UK -->
        @if (request()->routeIs('admin.dashboard.unit-kerja.indikator.edit'))
          @include('admin.unit-kerja.pernyataan-standar.edit', compact('unitKerja', 'standarKriteria', 'pernyataansUnitKerja'))
        @endif

        <!-- tambah measure UK -->
        @if (request()->routeIs('admin.dashboard.unit-kerja.standar-kriteria.pernyataan.measure.insert'))
          @include('admin.unit-kerja.pernyataan-standar.measure.create', compact('unitKerja', 'standarKriteria', 'pernyataanStandar'))
        @endif

        <!-- Edit measure UK -->
        @if (request()->routeIs('admin.dashboard.unit-kerja.standar-kriteria.pernyataan.measure.remove'))
          @include('admin.unit-kerja.pernyataan-standar.measure.edit', compact('unitKerja', 'standarKriteria', 'pernyataanStandar'))
        @endif

        @include('admin.unit-kerja.index', compact('unitKerjas'))
        <!-- Akhir Unit Kerja -->


        <!-- tambah ruang lingkup -->
        @if (request()->routeIs('admin.dashboard.ruang-lingkup.create'))
          @include('admin.ruang-lingkup.create')
        @endif

        <!-- edit ruang lingkup -->
        @if (request()->routeIs('admin.dashboard.ruang-lingkup.edit'))
          @include('admin.ruang-lingkup.edit', compact('rl_detail'))
        @endif

        @include('admin.ruang-lingkup.index', compact('ruangLingkups'))
      </section>

      <section class="col-xl-6">
        <!-- tambah standar kriteria -->
        @if (request()->routeIs('admin.dashboard.standar-kriteria.create'))
          @include('admin.standar-kriteria.create')
        @endif

        <!-- edit standar kriteria -->
        @if (request()->routeIs('admin.dashboard.standar-kriteria.edit'))
          @include('admin.standar-kriteria.edit', compact('sk_detail'))
        @endif

        <!-- tambah pernyataan -->
        @if (request()->routeIs('admin.dashboard.standar-kriteria.pernyataan.create'))
          @include('admin.standar-kriteria.pernyataan-standar.create', compact('sk_detail'))
        @endif

        <!-- edit pernyataan -->
        @if (request()->routeIs('admin.dashboard.standar-kriteria.pernyataan.edit'))
          @include('admin.standar-kriteria.pernyataan-standar.edit', compact('sk_detail_id', 'ps_detail'))
        @endif

        <!-- tambah indikator -->
        @if (request()->routeIs('admin.dashboard.standar-kriteria.pernyataan.indikator.create'))
          @include('admin.standar-kriteria.pernyataan-standar.indikator.create', compact('standarKriteria', 'pernyataan'))
        @endif

        <!-- tambah measure -->
        @if (request()->routeIs('admin.dashboard.standar-kriteria.pernyataan.measure.create'))
          @include('admin.standar-kriteria.pernyataan-standar.measure.create', compact('standarKriteria', 'pernyataan'))
        @endif

        @include('admin.standar-kriteria.index', compact('standarKriterias'))

        {{--List of Temuan--}}
        <div class="card" id="ptks-per-riwayat" style="min-height: 700px">
          <div class="card-header bg-gradient-lightblue">
            <h3 class="card-title">Daftar Temuan</h3>

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
            <div>
              <table class="mb-3 table-borderless">
                <tbody>
                <tr>
                  <td class="text-bold"><label class="m-0" for="ruang-lingkup">Ruang Lingkup</label></td>
                  <td class="d-flex align-items-center">
                    <span class="mx-2">{{ " : " }}</span>
                    <div class="d-inline-block">
                      <select id="ruang-lingkup" name="ruang-lingkup"
                              class="form-control select2bs4" data-placeholder="Pilih ruang lingkup..."
                      >
                        <option value="-1">Pilih...</option>
                        @foreach($ruangLingkups as $item)
                          <option {{ ($ptks->isNotEmpty() ? $ptks->first()->riwayat_audit->ruang_lingkup_id : null) === $item->id ? 'selected' : '' }}
                                  value="{{ $item->id }}"
                          >{{ $item->getRuangLingkupFormat() }}</option>
                        @endforeach
                      </select>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>

            <div class="table-data table-responsive p-0" style="max-height: 600px">
              <table class="table table-sm table-bordered table table-head-fixed table-hover"
                     id="ptk-table"
              >
                <thead class="thead-light">
                <tr>
                  <th class="text-center text-nowrap">No</th>
                  <th class="text-center text-nowrap">Tipe</th>
                  <th class="text-center text-nowrap">Unit Kerja</th>
                  <th class="text-center text-nowrap">Auditee</th>
                  <th class="text-center text-nowrap">Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($ptks as $item)
                  <tr data-widget="expandable-table" aria-expanded="false">
                    <td class="text-center text-nowrap">{{ $loop->iteration }}</td>
                    <td class="text-center text-nowrap">{{ $item->type ?? '-' }}</td>
                    <td class="text-nowrap">{{ $item->riwayat_audit !== null && $item->riwayat_audit->unit_kerja !== null ? \Str::limit($item->riwayat_audit->unit_kerja->nama, 20) : '-' }}</td>
                    <td class="text-nowrap">{{ $item->auditee !== null ? \Str::limit($item->auditee->name, 15) : '-' }}</td>
                    <td class="text-center text-nowrap">
                      @if ($item->is_approved_with_repaired_by_auditor)
                        <span style="padding:.125rem .75rem;" class="bg-info text-sm rounded-pill"
                        >Ditutup</span>
                      @elseif ($item->is_approved_by_auditee && $item->is_approved_by_auditor)
                        <span style="padding:.125rem .75rem;" class="bg-warning text-sm rounded-pill"
                        >Sedang Proses</span>
                      @else
                        <span style="padding:.125rem .75rem;" class="bg-secondary text-sm rounded-pill"
                        >Belum Ada Tindakan</span>
                      @endif
                    </td>
                  </tr>
                  <tr class="expandable-body d-none">
                    <td colspan="5">
                      <h6 class="card-header bg-gradient-navy">Detail Temuan</h6>

                      @if ($item->is_approved_with_repaired_by_auditor)
                        <div class="m-3 alert alert-success text-center" style="opacity:.9;" role="alert">
                          Perbaikan Sudah Diselesaikan
                        </div>
                      @elseif ($item->is_approved_by_auditee && $item->is_approved_by_auditor)
                        <div class="m-3 alert alert-warning text-center" style="opacity:.9;" role="alert">
                          <p class="m-0">Sedang Dalam Masa Perbaikan</p>
                          @if (\Carbon\CarbonImmutable::parse($item->repairing_datetime_finish)->addDay()->isPast())
                            <p class="p-0 m-0 text-red text-bold">Waktu sudah melebihi batas</p>
                            <i class="mr-2 fas fa-clock"></i>
                          @endif
                        </div>
                      @endif

                      <div class="d-flex flex-column">
                        <div>
                          <span class="text-bold">Auditor</span>
                          <div>{{ $item->auditor->name ?? 'Tidak ada' }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Auditee</span>
                          <div>{{ $item->auditee->name ?? 'Tidak ada' }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Tipe Temuan</span>
                          <div>{{ $item->type }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Standar Kriteria</span>
                          <div>{{ $item->checklist_audit->standarKriteria->nama ?? 'Tidak ada' }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Pernyataan Standar</span>
                          <div>{{ $item->checklist_audit->pernyataan_standar->pernyataan_standar ?? 'Tidak ada' }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Indikator</span>
                          <div>{{ $item->checklist_audit->indikator->indikator ?? 'Tidak ada' }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Measure</span>
                          <div>{{ $item->checklist_audit->measure->measure ?? 'Tidak ada' }}</div>
                        </div>

                        <div>
                          <span class="text-bold">Deskripsi Ketidaksesuaian</span>
                          <table class="table-borderless">
                            <tbody>
                            <tr>
                              <td class="text-bold">Problem</td>
                              <td>
                                <span class="ml-2">{{ ' : ' . $item->problem }}</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-bold">Location</td>
                              <td>
                                <span class="ml-2">{{ ' : ' . $item->location }}</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-bold">Objective</td>
                              <td>
                                <span class="ml-2">{{ ' : ' . $item->objective }}</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-bold">Reference</td>
                              <td>
                                <span class="ml-2">{{ ' : ' . $item->reference }}</span>
                              </td>
                            </tr>
                            </tbody>
                          </table>
                        </div>
                        <div>
                          <span class="text-bold">Analisa Akar Masalah</span>
                          <div>{{ $item->analisa_akar_masalah }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Akibat</span>
                          <div>{{ $item->akibat }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Rekomendasi/Permintaan Tindakan Koreksi</span>
                          <div>{{ $item->permintaan_tindakan_koreksi }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Rencana Tindakan Perbaikan</span>
                          <div>{{ $item->rencana_tindakan_perbaikan }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Rencana Pencegahan</span>
                          <div>{{ $item->rencana_pencegahan }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Penanggung Jawab Perbaikan</span>
                          <div>{{ $item->penanggungJawabPerbaikan->nama ?? '-' }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Waktu Mulai Perbaikan</span>
                          <div>{{ $item->repairing_datetime_start ? parse_date_to_iso_format($item->repairing_datetime_start) : '-' }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Batas Waktu Perbaikan</span>
                          <div>{{ $item->repairing_datetime_finish ? parse_date_to_iso_format($item->repairing_datetime_finish) : '-' }}</div>
                        </div>
                        <div>
                          <span class="text-bold">Status Temuan Auditor</span>
                          @if ($item->is_approved_by_auditor)
                            <div class="text-md d-flex align-items-center">
                              <i class="mr-1 fas fa-check-circle text-green text-lg"></i> Telah Disetujui
                            </div>
                          @else
                            <div class="text-md d-flex align-items-center">
                              <i class="mr-1 fas fa-exclamation-circle text-yellow text-lg"></i> Belum Disetujui
                            </div>
                          @endif
                        </div>
                        <div>
                          <span class="text-bold">Status Temuan Auditee</span>
                          @if ($item->is_approved_by_auditee)
                            <div class="text-md d-flex align-items-center">
                              <i class="mr-1 fas fa-check-circle text-green text-lg"></i> Telah Disetujui
                            </div>
                          @else
                            <div class="text-md d-flex align-items-center">
                              <i class="mr-1 fas fa-exclamation-circle text-yellow text-lg"></i> Belum Disetujui
                            </div>
                          @endif
                        </div>
                        @if ($item->is_approved_by_auditor && $item->is_approved_by_auditee)
                          <div>
                            <span class="text-bold">Status Perbaikan Auditor</span>
                            @if ($item->is_approved_with_repaired_by_auditor)
                              <div class="text-md d-flex align-items-center">
                                <i class="mr-1 fas fa-check-circle text-green text-lg"></i> Telah Disetujui
                              </div>
                            @else
                              <div class="text-md d-flex align-items-center">
                                <i class="mr-1 fas fa-exclamation-circle text-yellow text-lg"></i> Belum Disetujui
                              </div>
                            @endif
                          </div>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-center">Tidak ada data yang tersedia</td></tr>
                @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        {{--End of List of Temuans--}}
      </section>
      {{--End of First Row--}}
    </div>
	</div>
@endsection

@section('sidebar')
	@include('admin.sidebar')
@endsection

@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>$.widget.bridge('uibutton', $.ui.button)</script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- Moment -->
	<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
	<!-- Locales -->
	<script src="{{ asset('adminlte/plugins/moment/locales.min.js') }}"></script>
	<!-- Moment With Locale -->
	<script src="{{ asset('adminlte/plugins/moment/locale/id.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/moment/moment-with-locales.min.js') }}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	<!-- Select2 -->
	<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- InputMask -->
	<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
	<!-- overlayScrollbars -->
	<script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

	<script>
      $(document).ready(function () {
          // Overriding moment locale
          moment.updateLocale('id', {
              months: 'Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember'.split(
                  '_'
              ),
              monthsShort: 'Jan_Feb_Mar_Apr_Mei_Jun_Jul_Agt_Sep_Okt_Nov_Des'.split('_'),
              weekdays: 'Minggu_Senin_Selasa_Rabu_Kamis_Jumat_Sabtu'.split('_'),
              weekdaysShort: 'Min_Sen_Sel_Rab_Kam_Jum_Sab'.split('_'),
              weekdaysMin: 'Mg_Sn_Sl_Rb_Km_Jm_Sb'.split('_'),
              longDateFormat: {
                  LT: 'HH.mm',
                  LTS: 'HH.mm.ss',
                  L: 'DD/MM/YYYY',
                  LL: 'D MMMM YYYY',
                  LLL: 'D MMMM YYYY [pukul] HH.mm',
                  LLLL: 'dddd, D MMMM YYYY [pukul] HH.mm',
              },
              meridiemParse: /pagi|siang|sore|malam/,
              meridiemHour: function (hour, meridiem) {
                  if (hour === 12) {
                      hour = 0;
                  }
                  if (meridiem === 'pagi') {
                      return hour;
                  } else if (meridiem === 'siang') {
                      return hour >= 11 ? hour : hour + 12;
                  } else if (meridiem === 'sore' || meridiem === 'malam') {
                      return hour + 12;
                  }
              },
              meridiem: function (hours, minutes, isLower) {
                  if (hours < 11) {
                      return 'pagi';
                  } else if (hours < 15) {
                      return 'siang';
                  } else if (hours < 19) {
                      return 'sore';
                  } else {
                      return 'malam';
                  }
              },
              calendar: {
                  sameDay: '[Hari ini pukul] LT',
                  nextDay: '[Besok pukul] LT',
                  nextWeek: 'dddd [pukul] LT',
                  lastDay: '[Kemarin pukul] LT',
                  lastWeek: 'dddd [lalu pukul] LT',
                  sameElse: 'L',
              },
              relativeTime: {
                  future: 'dalam %s',
                  past: '%s yang lalu',
                  s: 'beberapa detik',
                  ss: '%d detik',
                  m: 'semenit',
                  mm: '%d menit',
                  h: 'sejam',
                  hh: '%d jam',
                  d: 'sehari',
                  dd: '%d hari',
                  M: 'sebulan',
                  MM: '%d bulan',
                  y: 'setahun',
                  yy: '%d tahun',
              },
              week: {
                  dow: 0, // Sunday is the first day of the week.
                  doy: 6, // The week that contains Jan 6th is the first week of the year.
              },
          });

          $('.select2').select2();

          //Initialize Select2 Elements
          $('select.select2bs4').select2({
              theme: 'bootstrap4'
          });

          $("#ptks-per-riwayat select#ruang-lingkup").change(function ($event) {
              const url = new URL(`{{ route('admin.riwayat-audit.filter-by-ruang-lingkup') }}`)
              url.searchParams.set('Ruang Lingkup[]', this.value);

              fetch(url.href)
                  .then(response => response.json())
                  .then(response => {
                      let templates = ``;
                      response.data.forEach((item, idx) => {
                          const bgTemuanStatus = item.is_approved_with_repaired_by_auditor ?
                              'info' : (
                                  item.is_approved_by_auditee && item.is_approved_by_auditor ? 'warning' : 'secondary'
                              );
                          const msgTemuanStatus = item.is_approved_with_repaired_by_auditor ?
                              'Ditutup' : (
                                  item.is_approved_by_auditee && item.is_approved_by_auditor ? 'Sedang Proses' : 'Belum Ada Tindakan'
                              );

                          let unitKerja = auditee = '-';
                          if (item.riwayat_audit != null && item.riwayat_audit.unit_kerja != null) {
                              unitKerja = item.riwayat_audit.unit_kerja.nama.slice(0,20) + (item.riwayat_audit.unit_kerja.nama.length > 20 ? '...' : '');
                          }
                          if (item.auditee != null) {
                              auditee = item.auditee.name.slice(0,15) + (item.auditee.name.length > 15 ? '...' : '');
                          }


                          let viewPerbaikanStatus = ``;
                          if (item.is_approved_by_auditor && item.is_approved_by_auditee) {
                              viewPerbaikanStatus += `
                                  <div>
                                      <span class="text-bold">Status Perbaikan oleh Auditor</span>
                                      <div class="text-md d-flex align-items-center">
                                        <i class="mr-1 fas ${item.is_approved_with_repaired_by_auditor ? 'fa-check-circle text-green' : 'fa-exclamation-circle text-yellow'} text-lg"></i>
                                        ${item.is_approved_with_repaired_by_auditor ? 'Telah Disetujui' : 'Belum Disetujui'}
                                      </div>
                                  </div>
                              `;
                          }

                          let statusTime = ``;
                          if (item.is_approved_with_repaired_by_auditor) {
                              statusTime += `
                                <div class="m-3 alert alert-success text-center" style="opacity:.9;" role="alert">
                                  Perbaikan Sudah Diselesaikan
                                </div>
                              `;
                          } else if (item.is_approved_by_auditee && item.is_approved_by_auditor){
                              statusTime += `
                                <div class="m-3 alert alert-warning text-center" style="opacity:.9;" role="alert">
                                  <p class="m-0">Sedang Dalam Masa Perbaikan</p>
                                  ${moment(item.repairing_datetime_finish).add(1, 'd').isBefore(moment()) ? `<p class="m-0 text-red text-bold">Waktu sudah melebihi batas</p>` : ``}
                                </div>
                              `;
                          }

                          templates += `
                              <tr data-widget="expandable-table" aria-expanded="false">
                                  <td class="text-center text-nowrap">${idx + 1}</td>
                                  <td class="text-center text-nowrap">${item.type}</td>
                                  <td class="text-nowrap">${unitKerja}</td>
                                  <td class="text-nowrap">${auditee}</td>
                                  <td class="text-center text-nowrap">
                                      <span style="padding:.125rem .75rem;" class="bg-${bgTemuanStatus} text-sm rounded-pill">
                                        ${msgTemuanStatus}
                                      </span>
                                  </td>
                              </tr>
                              <tr class="expandable-body d-none">
                                  <td colspan="5">
                                    <h6 class="card-header bg-gradient-navy">Detail Temuan</h6>
                                    ${statusTime}
                                    <div class="d-flex flex-column">
                                      <div>
                                        <span class="text-bold">Auditor</span>
                                        <div>${item.auditor ? item.auditor.name : 'Tidak ada'}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Auditee</span>
                                        <div>${item.auditee ? item.auditee.name : 'Tidak ada'}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Tipe Temuan</span>
                                        <div>${item.type}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Standar Kriteria</span>
                                        <div>${item.checklist_audit.standar_kriteria ? item.checklist_audit.standar_kriteria.nama : 'Tidak ada'}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Pernyataan Standar</span>
                                        <div>${item.checklist_audit.pernyataan_standar ? item.checklist_audit.pernyataan_standar.pernyataan_standar : 'Tidak ada'}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Indikator</span>
                                        <div>${item.checklist_audit.indikator ? item.checklist_audit.indikator.indikator : 'Tidak ada'}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Measure</span>
                                        <div>${item.checklist_audit.measure ? item.checklist_audit.measure.measure : 'Tidak ada'}</div>
                                      </div>

                                      <div>
                                        <span class="text-bold">Deskripsi Ketidaksesuaian</span>
                                        <table class="table-borderless">
                                          <tbody>
                                          <tr>
                                            <td class="text-bold">Problem</td>
                                            <td>
                                              <span class="ml-2">${" : " + item.problem}</span>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="text-bold">Location</td>
                                            <td>
                                              <span class="ml-2">${" : " + item.location}</span>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="text-bold">Objective</td>
                                            <td>
                                              <span class="ml-2">${" : " + item.objective}</span>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="text-bold">Reference</td>
                                            <td>
                                              <span class="ml-2">${" : " + item.reference}</span>
                                            </td>
                                          </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                      <div>
                                        <span class="text-bold">Analisa Akar Masalah</span>
                                        <div>${item.analisa_akar_masalah}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Akibat</span>
                                        <div>${item.akibat}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Rekomendasi/Permintaan Tindakan Koreksi</span>
                                        <div>${item.permintaan_tindakan_koreksi}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Rencana Tindakan Perbaikan</span>
                                        <div>${item.rencana_tindakan_perbaikan}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Rencana Pencegahan</span>
                                        <div>${item.rencana_pencegahan}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Penanggung Jawab Perbaikan</span>
                                        <div>${item.penanggungJawabPerbaikan ? item.penanggungJawabPerbaikan.nama : '-'}</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Waktu Mulai Perbaikan</span>
                                        <div>${item.repairing_datetime_start ? moment(item.repairing_datetime_start).format('LL') : '-' }</div>
                                      </div>
                                      <div>
                                        <span class="text-bold">Batas Waktu Perbaikan</span>
                                        <div>${item.repairing_datetime_finish ? moment(item.repairing_datetime_finish).format('LL') : '-' }</div>
                                      </div>
                                      <div>
                                          <span class="text-bold">Status Temuan oleh Auditor</span>
                                          <div class="text-md d-flex align-items-center">
                                            <i class="mr-1 fas ${item.is_approved_by_auditor ? 'fa-check-circle text-green' : 'fa-exclamation-circle text-yellow'} text-lg"></i>
                                            ${item.is_approved_by_auditor ? 'Telah Disetujui' : 'Belum Disetujui'}
                                          </div>
                                      </div>
                                      <div>
                                          <span class="text-bold">Status Temuan oleh Auditee</span>
                                          <div class="text-md d-flex align-items-center">
                                            <i class="mr-1 fas ${item.is_approved_by_auditee ? 'fa-check-circle text-green' : 'fa-exclamation-circle text-yellow'} text-lg"></i>
                                            ${item.is_approved_by_auditee ? 'Telah Disetujui' : 'Belum Disetujui'}
                                          </div>
                                      </div>
                                      ${viewPerbaikanStatus}
                                    </div>
                                  </td>
                              </tr>
                          `;
                      });
                      if (templates.length === 0)
                          templates += `<tr><td colspan="5" class="text-center">Tidak ada data yang tersedia</td></tr>`;

                      $('#ptks-per-riwayat #ptk-table tbody').html(templates);
                  })
                  .catch(error => {
                      console.error("Fetch PTK");
                      console.error(error);
                  });
          })

          //Date Time Picker
          $('#tahun_ajaran_mulai_date_picker').datetimepicker({
              @if (request()->routeIs('admin.dashboard.ruang-lingkup.edit'))
              defaultDate: new Date($('#tahun_ajaran_mulai_hidden').val()),
              @endif
              locale: 'id',
              format: 'YYYY',
              minViewMode: 'years',
              viewMode: 'years',
              pickTime: false,
          });
          $('#tahun_ajaran_selesai_date_picker').datetimepicker({
              @if (request()->routeIs('admin.dashboard.ruang-lingkup.edit'))
              defaultDate: new Date($('#tahun_ajaran_selesai_hidden').val()),
              @endif
              locale: 'id',
              format: 'YYYY',
              minViewMode: 'years',
              viewMode: 'years',
              pickTime: false,
          });

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

          /*Delete Unit Kerja*/
          $('#unitKerja .uk-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Unit Kerja ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (parseInt($($el).data().riwayatAuditsCount)) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: 'Maaf, anda tidak bisa menghapus unit kerja ini karena memiliki dokumen riwayat audit',
                              });
                          } else if (parseInt($($el).data().auditeesCount)) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: `Maaf, anda tidak bisa menghapus unit kerja ini karena memiliki ${$($el).data().auditeesCount} auditee`,
                              });
                          } else {
                              $(`#uk-delete-form-${$($el).data().uk}`).submit()
                          }
                      }
                  })
              });
          });

          /*Delete Ruang Lingkup*/
          $('#ruang-lingkup .rl-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Ruang Lingkup ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (parseInt($($el).data().riwayatAuditsCount) > 0) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: "Maaf, Anda tidak bisa menghapus ruang lingkup ini karena sedang terhubung dengan suatu riwayat audit.",
                              });
                          } else {
                              $(`#rl-delete-form-${$($el).data().rlId}`).submit()
                          }
                      }
                  })
              });
          });

          /*Delete Standar Kriteria*/
          $('#standar-kriteria .sk-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Standar Kriteria ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (parseInt($($el).data().pernyataanUkCount) > 0) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: "Maaf, Anda tidak bisa menghapus standar kriteria ini karena sedang terhubung dengan suatu unit kerja.",
                              });
                          } else {
                              $(`#sk-delete-form-${$($el).data().skId}`).submit()
                          }
                      }
                  })
              });
          });

          /*Delete Pernyataan Standar*/
          $('#standar-kriteria .pernyataan-sk-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Pernyataan Standar ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (parseInt($($el).data().pernyataanUkCount) > 0) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: "Maaf, Anda tidak bisa menghapus pernyataan ini karena sedang terhubung dengan suatu unit kerja.",
                              });
                          } else {
                              $(`#pernyataan-sk-delete-form-${$($el).data().pernyataanSk}`).submit();
                          }
                      }
                  })
              });
          });

          /*Delete Indikator Pernyataan Standar*/
          $('#standar-kriteria .indikator-ps-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Indikator Pernyataan Standar ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (parseInt($($el).data().checklistAuditsCount) > 0) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: "Maaf, Anda tidak bisa menghapus indikator ini karena sedang terhubung dengan suatu checklist audit.",
                              });
                          } else {
                              $(`#indikator-ps-delete-form-${$($el).data().indikatorId}`).submit()
                          }
                      }
                  })
              });
          });

          /*Delete Measure Pernyataan Standar*/
          $('#standar-kriteria .measure-ps-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Measure Pernyataan Standar ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (parseInt($($el).data().pernyataanUkCount) > 0) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: "Maaf, Anda tidak bisa menghapus measure ini karena sedang terhubung dengan suatu unit kerja.",
                              });
                          } else {
                              $(`#measure-ps-delete-form-${$($el).data().measurePs}`).submit()
                          }
                      }
                  })
              });
          });
          /*SweetAlert2*/
      });

			@if (request()->routeIs('admin.dashboard.standar-kriteria.pernyataan.indikator.create') || request()->routeIs('admin.dashboard.standar-kriteria.pernyataan.edit'))
      const indikatorInputContainer = document.querySelector('#indikator-form .indikator-container');
      const numberOfIndikator = indikatorInputContainer.previousElementSibling.firstElementChild;

      function addIndikatorInput() {
          while (indikatorInputContainer.hasChildNodes()) {
              indikatorInputContainer.removeChild(indikatorInputContainer.lastChild);
          }
          for (let i = 0; i < numberOfIndikator.value; i++) {
              const input = document.createElement("textarea");
              input.setAttribute("rows", "3");
              input.setAttribute("name", "indikator" + (i + 1));
              input.setAttribute("placeholder", `Masukkan indikator ke-${i + 1}...`);
              input.classList.add('form-control');
              input.classList.add('mb-2');
              indikatorInputContainer.appendChild(input);
          }
      }
			@endif

			@if (request()->routeIs('admin.dashboard.standar-kriteria.pernyataan.measure.create') || request()->routeIs('admin.dashboard.standar-kriteria.pernyataan.edit'))
      const measureInputContainer = document.querySelector('#measure-form .measure-container');
      function addMeasureInput() {
          while (measureInputContainer.hasChildNodes()) {
              measureInputContainer.removeChild(measureInputContainer.lastChild);
          }
          for (let i = 0; i < measureInputContainer.previousElementSibling.firstElementChild.value; i++) {
              const input = document.createElement("textarea");
              input.setAttribute("rows", "3");
              input.setAttribute("name", "measure" + (i + 1));
              input.setAttribute("placeholder", `Masukkan measure ke-${i + 1}...`);
              input.classList.add('form-control');
              input.classList.add('mb-2');
              measureInputContainer.appendChild(input);
          }
      }
			@endif

      function addPernyataanInput(e, ukId) {
          console.log(e.target.value);
          fetch(`/admin/dashboard/unit-kerja/${ukId}/standar-kriteria/${e.target.value}/indikator`)
              .then(response => response.json())
              .then(response => {
                  let pernyataans = '';
                  response.data.forEach(function (data, i) {
                      pernyataans += `<option value="${data.id}">${data.pernyataan_standar}</option>`;
                  });
                  $('select#pernyataan').html(pernyataans);
              })
              .catch(error => console.log(error));
      }

	</script>
@endsection
