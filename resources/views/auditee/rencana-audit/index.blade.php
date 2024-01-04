@extends('layouts.app')

@section('title', 'Daftar Rencana Audit Unit')

@section('styles')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
          @if (request()->routeIs('auditee.rencana-audit.riwayat-audit.index'))
            <li class="breadcrumb-item active">Daftar Riwayat Rencana Audit</li>
          @elseif (request()->routeIs('auditee.rencana-audit.riwayat-audit.show'))
            <li class="text-sm breadcrumb-item">
              <a href="{{ route('auditee.rencana-audit.riwayat-audit.index') }}">
                Daftar Riwayat Rencana Audit
              </a>
            </li>
          @endif
          @if (request()->routeIs('auditee.rencana-audit.riwayat-audit.show'))
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
      <section class="col">
        <div class="card" id="riwayat-rencana-audit">
          <div class="card-header bg-gradient-lightblue">
            <h3 class="card-title">Daftar Riwayat Rencana Audit</h3>

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
            @if (request()->routeIs('auditee.rencana-audit.riwayat-audit.index') && session()->has('status') && session()->has('message'))
              <div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
                <span>{{session()->get('message')}}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

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
                      {{ $item->auditee->name }}
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
                       href="{{ route('auditee.rencana-audit.riwayat-audit.show', [$item->id]) }}#rencana-audits">
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

    @if (request()->routeIs('auditee.rencana-audit.riwayat-audit.show'))
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
              @if (request()->routeIs('auditee.rencana-audit.riwayat-audit.show') && session()->has('status') && session()->has('message'))
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
                            {{ $riwayatAudit->auditee->name }}
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
                            {{ $riwayatAudit->ruang_lingkup->getRuangLingkupFormat() }}
                          @else
                            -
                          @endif
                        </span>
                      </td>
                    </tr>
                    </tbody>
                  </table>
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
                </tr>
                </thead>
                <tbody>
                @foreach ($rencanaAudits as $item)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                      @if ($item->standarKriteria)
                        {{ $item->standarKriteria->nama }}
                      @else
                        <div class="text-center">-</div>
                      @endif
                    </td>
                    <td>{{ $item->sub_unit_kerja }}</td>
                    <td>
                      @if ($item->auditor)
                        {{ $item->auditor->name }}
                      @else
                        <div class="text-center">-</div>
                      @endif
                    </td>
                    <td>
                      @if ($item->auditee)
                        {{ $item->auditee->name }}
                      @else
                        <div class="text-center">-</div>
                      @endif
                    </td>
                    <td>{{ $item->dokumen }}</td>
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
  @include('auditee.sidebar')
@endsection

@section('scripts')
  <!-- jQuery -->
  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
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
          /*Datatables*/
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

          /*Select2*/
          $('.select2').select2()

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          })
      });
  </script>
@endsection
