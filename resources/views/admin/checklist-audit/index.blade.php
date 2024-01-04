@extends('layouts.app')

@section('title', 'Daftar Checklist Audit Unit')

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
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet"
        href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
@endsection

@section('content-header')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col">
        <ol class="text-sm breadcrumb float-sm-right">
          @if (request()->routeIs('admin.checklist-audit.indexUnitKerja'))
            <li class="breadcrumb-item active">{{__('Beranda')}}</li>
          @elseif (request()->routeIs('admin.checklist-audit.riwayat-audit.index') || request()->routeIs('admin.checklist-audit.riwayat-audit.show') || request()->routeIs('admin.checklist-audit.show'))
            <li class="text-sm breadcrumb-item">
              <a href="{{ route('admin.checklist-audit.indexUnitKerja') }}">
                {{__('Beranda')}}
              </a>
            </li>
          @endif
          @if (request()->routeIs('admin.checklist-audit.riwayat-audit.index'))
            <li class="breadcrumb-item active">Daftar Riwayat Checklist - {{ $unitKerja->nama }}</li>
          @elseif (request()->routeIs('admin.checklist-audit.riwayat-audit.show') || request()->routeIs('admin.checklist-audit.show'))
            <li class="text-sm breadcrumb-item">
              <a href="{{ route('admin.checklist-audit.riwayat-audit.index', [$unitKerja->id]) }}">
                Daftar Riwayat Checklist - {{ $unitKerja->nama }}
              </a>
            </li>
          @endif
          @if (request()->routeIs('admin.checklist-audit.riwayat-audit.show'))
            <li class="breadcrumb-item active">Daftar Checklist Audit</li>
          @elseif (request()->routeIs('admin.checklist-audit.show'))
            <li class="text-sm breadcrumb-item">
              <a href="{{ route('admin.checklist-audit.riwayat-audit.index', [$unitKerja->id]) }}">
                Daftar Checklist Audit
              </a>
            </li>
          @endif
          @if (request()->routeIs('admin.checklist-audit.show'))
            <li class="breadcrumb-item active">Detail Checklist Audit</li>
          @endif
        </ol>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col">
        <h1 class="m-0">Checklist Audit Unit</h1>
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
            @if (request()->routeIs('admin.checklist-audit.indexUnitKerja') && session()->has('status') && session()->has('message'))
              <div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
                <span>{!!session()->get('message')!!}</span>
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
                <th class="text-center text-nowrap">Total Riwayat Checklist Audit</th>
                <th class="text-center text-nowrap">Aksi</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($unitKerjas as $item)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>{{ $item->nama }}</td>
                  <td class="text-center">
                    {{ $item->riwayat_audits_count }}
                  </td>
                  <td class="text-right d-flex justify-content-center align-items-center flex-wrap" style="gap: 0.5rem">
                    <a class="btn btn-primary btn-xs text-nowrap"
                       href="{{ route('admin.checklist-audit.riwayat-audit.index', [$item->id]) }}#history-checklist-audit">
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

    @if (request()->routeIs('admin.checklist-audit.riwayat-audit.index') || request()->routeIs('admin.checklist-audit.riwayat-audit.show') || request()->routeIs('admin.checklist-audit.show'))
      <div class="row">
        <section class="col">
          <div class="card" id="history-checklist-audit">
            <div class="card-header bg-gradient-lightblue">
              <h3 class="card-title">Daftar Riwayat Checklist Audit</h3>

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
              @if (request()->routeIs('admin.checklist-audit.riwayat-audit.index') && session()->has('status') && session()->has('message'))
                <div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
                  <span>{!!session()->get('message')!!}</span>
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

              <table id="history-checklist-audit-table" style="width: 100%"
                     class="table table-sm table-striped table-bordered table-hover">
                <thead>
                <tr>
                  <th class="text-center text-nowrap">No</th>
                  <th class="text-center text-nowrap">Tanggal Rencana</th>
                  <th class="text-center text-nowrap">Ruang Lingkup</th>
                  <th class="text-center text-nowrap">Tim Auditor</th>
                  <th class="text-center text-nowrap">Ketua Auditee</th>
                  <th class="text-center text-nowrap">Total Checklist Audit</th>
                  <th class="text-center text-nowrap">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($riwayatAudits as $item)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_rencana)->locale(config('app.locale'))->timezone(config('app.timezone'))->isoFormat('LL') }}</td>
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
                    <td class="text-center">
                      {{ $item->checklist_audits_count ?: 0 }}
                    </td>
                    <td class="text-right d-flex justify-content-center align-items-center flex-wrap"
                        style="gap: 0.5rem">
                      <a class="btn btn-primary btn-xs text-nowrap"
                         href="{{ route('admin.checklist-audit.riwayat-audit.show', [$unitKerja->id, $item->id]) }}#checklist-audits-table">
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

    @if (request()->routeIs('admin.checklist-audit.riwayat-audit.show') || request()->routeIs('admin.checklist-audit.show'))
      <div class="row">
        <section class="col">
          <!-- Default box -->
          <div class="card" id="checklist-audits">
            <div class="card-header bg-gradient-lightblue">
              <h3 class="card-title">Daftar Checklist Audit Unit</h3>

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
              @if (request()->routeIs('admin.checklist-audit.riwayat-audit.show') && session()->has('status') && session()->has('message'))
                <div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
                  <span>{!!session()->get('message')!!}</span>
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
                      <td class="text-bold">Tanggal Rencana</td>
                      <td>
												<span class="ml-4">
													{{ ' : ' . \Carbon\Carbon::parse($riwayatAudit->tanggal_rencana)->locale(config('app.locale'))->timezone(config('app.timezone'))->isoFormat('LL') }}
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
                            {{$riwayatAudit->auditee->name}}
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
                            {{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
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
                  <a href="{{ route('admin.checklist-audit.create', [$unitKerja->id, $riwayatAudit->id]) }}"
                     class="btn btn-primary">
                    <i class="mr-2 fas fa-plus"></i>Checklist Audit
                  </a>
                  <a href="{{ route('admin.checklist-audit.riwayat-pdf', [$unitKerja->id, $riwayatAudit->id]) }}"
                     class="btn btn-primary">
                    <i class="mr-2 fas fa-file"></i>PDF
                  </a>
                </div>
              </div>

              <table id="checklist-audits-table" style="width: 100%"
                     class="table table-sm table-bordered table-hover">
                <thead>
                <tr>
                  <th class="text-center text-nowrap">No</th>
                  <th class="text-center text-nowrap">Standar Kriteria</th>
                  <th class="text-center text-nowrap">Measure</th>
                  <th class="text-center text-nowrap">Auditor</th>
                  <th class="text-center text-nowrap">Auditee</th>
                  <th class="text-center text-nowrap">Status</th>
                  <th class="text-center text-nowrap">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($checklistAudits as $item)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                      @if ($item->standarKriteria)
                        {{$item->standarKriteria->nama}}
                      @else
                        <div class="text-center">-</div>
                      @endif
                    </td>
                    <td>
                      @if ($item->measure)
                        {{\Str::limit($item->measure->measure, 50)}}
                      @else
                        <div class="text-center">-</div>
                      @endif
                    </td>
                    <td>
                      @if ($item->auditor)
                        {{$item->auditor->name}}
                      @else
                        <div class="text-center">-</div>
                      @endif
                    </td>
                    <td>
                      @if ($item->auditee)
                        {{$item->auditee->name}}
                      @else
                        <div class="text-center">-</div>
                      @endif
                    </td>
                    <td class="text-center text-nowrap">
                      @if ($item->is_approved_by_admin && $item->is_marked_as_audit_completed && $item->is_approved_by_auditor)
                        <span style="padding:.125rem .75rem;" class="bg-success text-sm rounded-pill"
                        ><i class="mr-1 fas fa-thumbs-up"></i>Selesai</span>
                      @elseif ($item->is_marked_as_audit_completed && $item->is_approved_by_auditor)
                        <span style="padding:.125rem .75rem;" class="bg-info text-sm rounded-pill"
                        >Selesai Diaudit</span>
                      @elseif ($item->is_approved_by_auditor)
                        <span style="padding:.125rem .75rem;" class="bg-warning text-sm rounded-pill"
                        ><i class="mr-1 far fa-clock"></i>Sedang Diaudit</span>
                      @else
                        <span style="padding:.125rem .75rem;" class="bg-secondary text-sm rounded-pill"
                        >Belum Diaudit</span>
                      @endif
                    </td>
                    <td class="text-right d-flex justify-content-center align-items-center flex-wrap"
                        style="gap: 0.5rem">
                      <a href="{{ route('admin.checklist-audit.pdf', [$unitKerja->id, $riwayatAudit->id, $item->id, 'number' => $loop->iteration]) }}"
                         class="btn btn-xs btn-primary">
                        <i class="mr-2 fas fa-file"></i>PDF
                      </a>
                      <a class="btn btn-primary btn-xs text-nowrap text-nowrap"
                         href="{{ route('admin.checklist-audit.show', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}#detail-checklist-audit">
                        <i class="mr-2 fas fa-eye"></i>Show
                      </a>
                      @if ($item->is_approved_by_admin)
                        @if ($item->is_marked_as_ptk)
                          <a class="btn btn-primary btn-xs text-nowrap checklist-audit-markAsNotPTK-btn"
                             title="Tandai Bukan sebagai Temuan"
                             href="{{ route('admin.checklist-audit.markAsNotPTK', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}"
                             onclick="event.preventDefault();document.getElementById('checklist-audit-markAsNotPTK-form-{{$item->id}}').submit()"
                          ><i class="fas fa-circle"></i>
                          </a>
                          <form id="checklist-audit-markAsNotPTK-form-{{ $item->id }}" class="d-none" method="POST"
                                action="{{ route('admin.checklist-audit.markAsNotPTK', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}">
                            @csrf
                            @method("PUT")
                          </form>
                        @else
                          <a class="btn btn-primary btn-xs text-nowrap checklist-audit-markAsPTK-btn"
                             title="Tandai sebagai PTK"
                             href="{{ route('admin.checklist-audit.markAsPTK', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}"
                             onclick="event.preventDefault();document.getElementById('checklist-audit-markAsPTK-form-{{$item->id}}').submit()"
                          ><i class="far fa-circle"></i>
                          </a>
                          <form id="checklist-audit-markAsPTK-form-{{ $item->id }}" class="d-none" method="POST"
                                action="{{ route('admin.checklist-audit.markAsPTK', [$unitKerja->id, $riwayatAudit->id, $item->id]) }}">
                            @csrf
                            @method("PUT")
                          </form>
                        @endif
                      @else
                        <button class="btn btn-primary btn-xs text-nowrap"
                                title="Tandai sebagai Temuan" disabled
                        ><i class="far fa-circle"></i></button>
                      @endif
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

    @if (request()->routeIs('admin.checklist-audit.show'))
      <div class="row">
        <section class="col-xl-6 col-lg-9 col-md-10 col-sm-11 col-12">
          <!-- Default box -->
          <div class="card" id="detail-checklist-audit">
            <div class="card-header bg-gradient-lightblue">
              <h3 class="card-title">Detail Checklist Audit Unit</h3>

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
              @if (request()->routeIs('admin.checklist-audit.riwayat-audit.show') || request()->routeIs('admin.checklist-audit.show') && session()->has('status') && session()->has('message'))
                <div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
                  <span>{!!session()->get('message')!!}</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif

              @if ($checklistAudit->is_approved_by_admin && $checklistAudit->is_marked_as_audit_completed && $checklistAudit->is_approved_by_auditor)
                <div class="alert alert-success text-center" style="opacity:.9;" role="alert">
                  <i class="mr-1 fas fa-thumbs-up"></i>Selesai
                </div>
              @elseif ($checklistAudit->is_marked_as_audit_completed && $checklistAudit->is_approved_by_auditor)
                <div class="alert alert-info text-center" style="opacity:.9;" role="alert">
                  Selesai Diaudit
                </div>
              @elseif ($checklistAudit->is_approved_by_auditor)
                <div class="alert alert-warning text-center" style="opacity:.9;" role="alert">
                  <i class="mr-1 far fa-clock"></i>Sedang Diaudit
                </div>
              @endif

              <div class="d-flex flex-column">
                <div>
                  <span class="text-bold">Auditor</span>
                  <p>{{ $checklistAudit->auditor->name ?? 'Tidak ada'}}</p>
                </div>
                <div>
                  <span class="text-bold">Auditee</span>
                  <p>{{ $checklistAudit->auditee->name ?? 'Tidak ada'}}</p>
                </div>
                <div>
                  <span class="text-bold">Standar Kriteria</span>
                  <p>{{ $checklistAudit->standarKriteria->nama ?? 'Tidak ada' }}</p>
                </div>
                <div>
                  <span class="text-bold">Pernyataan Standar</span>
                  <p>{{ $checklistAudit->pernyataan_standar->pernyataan_standar ?? 'Tidak ada' }}</p>
                </div>
                <div>
                  <span class="text-bold">Indikator</span>
                  <p>{{ $checklistAudit->indikator->indikator ?? 'Tidak ada' }}</p>
                </div>
                <div>
                  <span class="text-bold">Measure</span>
                  <p>{{ $checklistAudit->measure->measure ?? 'Tidak ada'}}</p>
                </div>
                <div>
                  <span class="text-bold">Tentatif Audit Objektif</span>
                  <p>{{ $checklistAudit->tentatif_audit_objektif }}</p>
                </div>
                <div>
                  <span class="text-bold">Tujuan Audit</span>
                  <p>{{ $checklistAudit->tujuan}}</p>
                </div>
                <div>
                  <span class="text-bold">Langkah Kerja</span>
                  @if ($checklistAudit->langkah_kerja_checklists->isNotEmpty())
                    <ul class="pl-4">
                      @foreach ($checklistAudit->langkah_kerja_checklists as $item)
                        <li>
                          <span class="mr-1">{{$item->langkah_kerja}}</span>

                          @if ($checklistAudit->is_marked_as_audit_completed)
                            @if ($item->is_audited)
                              <span class="px-2 rounded-pill bg-success"><i class="fas fa-check"></i></span>
                            @else
                              <span class="px-2 rounded-pill bg-danger"><i class="mx-1 fas fa-times"></i></span>
                            @endif
                          @elseif ($checklistAudit->is_approved_by_auditor)
                            @if ($item->is_audited)
                              <a class="btn btn-warning btn-xs text-nowrap checklist-audit-langkah-kerja-markasunaudited-btn"
                                 title="Tandai Belum Teraudit"
                                 href="{{ route('admin.checklist-audit.langkah-kerja.markAsUnaudited', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $item->id]) }}"
                                 onclick="event.preventDefault();document.getElementById('checklist-audit-langkah-kerja-markasunaudited-form-{{$item->id}}').submit()"
                              ><span class="px-2"><i class="mr-1 fas fa-exclamation"></i>Tandai Tidak Terpenuhi</span>
                              </a>
                              <form id="checklist-audit-langkah-kerja-markasunaudited-form-{{ $item->id }}"
                                    class="d-none" method="POST"
                                    action="{{ route('admin.checklist-audit.langkah-kerja.markAsUnaudited', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $item->id]) }}">
                                @csrf
                                @method("PUT")
                              </form>
                            @else
                              <a class="btn btn-default btn-xs text-nowrap checklist-audit-langkah-kerja-markasaudited-btn"
                                 title="Tandai Telah Teraudit"
                                 href="{{ route('admin.checklist-audit.langkah-kerja.markAsAudited', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $item->id]) }}"
                                 onclick="event.preventDefault();document.getElementById('checklist-audit-langkah-kerja-markasaudited-form-{{$item->id}}').submit()"
                              ><span class="px-1"><i class="mr-1 fas fa-check"></i>Tandai Terpenuhi</span>
                              </a>
                              <form id="checklist-audit-langkah-kerja-markasaudited-form-{{ $item->id }}"
                                    class="d-none" method="POST"
                                    action="{{ route('admin.checklist-audit.langkah-kerja.markAsAudited', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $item->id]) }}">
                                @csrf
                                @method("PUT")
                              </form>
                            @endif
                          @endif
                        </li>
                      @endforeach
                    </ul>
                  @else
                    <p>Tidak ada langkah kerja</p>
                  @endif
                  @if (!$checklistAudit->is_approved_by_auditor)
                    <div class="mb-2">
                      <a href="{{route('admin.checklist-audit.langkah-kerja.create', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id])}}"
                         class="btn btn-sm text-nowrap btn-primary"
                      ><i class="mr-2 fas fa-plus"></i>Tambah Langkah Kerja</a>
                      <a href="{{route('admin.checklist-audit.langkah-kerja.edit', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id])}}"
                         class="btn btn-sm text-nowrap btn-warning"
                      ><i class="mr-2 fas fa-pen"></i>Edit Langkah Kerja</a>
                    </div>
                  @endif
                </div>
                <div>
                  <span class="text-bold">Disusun oleh Auditor</span>
                  @if ($checklistAudit->is_marked_as_audit_completed && $checklistAudit->is_approved_by_auditor)
                    <p class="text-md d-flex align-items-center">
                      <i class="mr-2 fas fa-check-circle text-green text-lg"></i>Selesai diaudit
                    </p>
                  @else
                    <p class="text-md d-flex align-items-center">
                      <i class="mr-2 fas fa-exclamation-circle text-yellow text-lg"></i>Belum diaudit
                    </p>
                  @endif
                </div>
                <div>
                  <span class="text-bold">Diperiksa oleh Kabag SAI</span>
                  @if ($checklistAudit->is_approved_by_admin && $checklistAudit->is_marked_as_audit_completed && $checklistAudit->is_approved_by_auditor)
                    <p class="text-md d-flex align-items-center">
                      <i class="mr-2 fas fa-check-circle text-green text-lg"></i>Telah diperiksa
                    </p>
                  @else
                    <p class="text-md d-flex align-items-center">
                      <i class="mr-2 fas fa-exclamation-circle text-yellow text-lg"></i>Belum diperiksa
                    </p>
                  @endif
                </div>
                @if ($checklistAudit->is_approved_by_admin)
                  <div>
                    <span class="text-bold">Apakah Menjadi Temuan PTK/OAI</span>
                    @if ($checklistAudit->is_marked_as_ptk)
                      <p class="text-md d-flex align-items-center">
                        <i class="mr-2 fas fa-check-circle text-green text-lg"></i>Menjadi temuan
                      </p>
                    @else
                      <p class="text-md d-flex align-items-center">
                        <i class="mr-2 fas fa-exclamation-circle text-yellow text-lg"></i>Tidak menjadi temuan
                      </p>
                    @endif
                  </div>
                @endif
              </div>

              <div class="mt-2 d-flex flex-column justify-content-center align-items-center" style="gap: .5rem">
                <div class="d-flex justify-content-center align-items-center" style="gap: .25rem">
                  @if ($checklistAudit->is_approved_by_auditor)
                    {{-- Jika audit belum selesai dilakukan --}}
                    @if ($checklistAudit->is_marked_as_audit_completed)
                      @if ($checklistAudit->is_approved_by_admin)
                        <a class="btn btn-default text-nowrap checklist-audit-markasunchecked-btn"
                           data-is-have-ptk="{{$checklistAudit->ptk !== null}}"
                           data-checklist-audit-id="{{$checklistAudit->id}}"
                           title="Tandai Belum Diperiksa"
                           href="{{ route('admin.checklist-audit.markAsUnchecked', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                        ><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Belum Diperiksa
                        </a>
                        <form id="checklist-audit-markasunchecked-form-{{ $checklistAudit->id }}"
                              class="d-none" method="POST"
                              action="{{ route('admin.checklist-audit.markAsUnchecked', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                          @csrf
                          @method("PUT")
                        </form>

                        {{-- Menandai checklist sebagai Temuan --}}
                        @if ($checklistAudit->is_marked_as_ptk)
                          <a class="btn btn-default text-nowrap detail-checklist-markAsNotPTK-btn"
                             title="Tandai Bukan sebagai Temuan"
                             href="{{ route('admin.checklist-audit.markAsNotPTK', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                             onclick="event.preventDefault();document.getElementById('detail-checklist-markAsNotPTK-form-{{$checklistAudit->id}}').submit()"
                          ><i class="mr-2 fas fa-exclamation"></i>Tandai Bukan Sebagai temuan
                          </a>
                          <form id="detail-checklist-markAsNotPTK-form-{{ $checklistAudit->id }}"
                                class="d-none" method="POST"
                                action="{{ route('admin.checklist-audit.markAsNotPTK', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                            @csrf
                            @method("PUT")
                          </form>
                        @else
                          <a class="btn btn-default text-nowrap detail-checklist-markAsPTK-btn"
                             title="Tandai Sebagai Temuan"
                             href="{{ route('admin.checklist-audit.markAsPTK', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                             onclick="event.preventDefault();document.getElementById('detail-checklist-markAsPTK-form-{{$checklistAudit->id}}').submit()"
                          ><i class="mr-2 fas fa-check"></i>Tandai Sebagai Temuan
                          </a>
                          <form id="detail-checklist-markAsPTK-form-{{ $checklistAudit->id }}"
                                class="d-none" method="POST"
                                action="{{ route('admin.checklist-audit.markAsPTK', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                            @csrf
                            @method("PUT")
                          </form>
                        @endif
                      @else
                        <a class="btn btn-default text-nowrap checklist-audit-markaschecked-btn"
                           href="{{ route('admin.checklist-audit.markAsChecked', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                           onclick="event.preventDefault();document.getElementById('checklist-audit-markaschecked-form-{{$checklistAudit->id}}').submit()"
                        ><i class="mr-2 fas fa-check text-md"></i>Tandai Telah Diperiksa
                        </a>
                        <form id="checklist-audit-markaschecked-form-{{ $checklistAudit->id }}"
                              class="d-none" method="POST"
                              action="{{ route('admin.checklist-audit.markAsChecked', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                          @csrf
                          @method("PUT")
                        </form>
                      @endif
                    @endif

                    @if (!$checklistAudit->is_approved_by_admin)
                      @if ($checklistAudit->is_marked_as_audit_completed)
                        <a class="btn btn-default text-nowrap checklist-audit-markAsAuditUncompleted-btn"
                           data-checklist-audit="{{$checklistAudit->id}}"
                           href="{{ route('admin.checklist-audit.markAsAuditUncompleted', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                           onclick="event.preventDefault();document.getElementById('checklist-audit-markAsAuditUncompleted-form-{{$checklistAudit->id}}').submit()"
                        ><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Belum Selesai Diaudit
                        </a>
                        <form id="checklist-audit-markAsAuditUncompleted-form-{{ $checklistAudit->id }}"
                              class="d-none" method="POST"
                              action="{{ route('admin.checklist-audit.markAsAuditUncompleted', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                          @csrf
                          @method("PUT")
                        </form>
                      @else
                        <a class="btn btn-default text-nowrap checklist-audit-markAsAuditCompleted-btn"
                           data-checklist-audit="{{$checklistAudit->id}}"
                           href="{{ route('admin.checklist-audit.markAsAuditCompleted', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                           onclick="event.preventDefault();document.getElementById('checklist-audit-markAsAuditCompleted-form-{{$checklistAudit->id}}').submit()"
                        ><i class="mr-2 fas fa-check text-md"></i>Tandai Telah Selesai Diaudit
                        </a>
                        <form id="checklist-audit-markAsAuditCompleted-form-{{ $checklistAudit->id }}"
                              class="d-none" method="POST"
                              action="{{ route('admin.checklist-audit.markAsAuditCompleted', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                          @csrf
                          @method("PUT")
                        </form>

                        <a class="btn btn-default text-nowrap checklist-audit-markasuncreated-btn"
                           data-checklist-audit="{{$checklistAudit->id}}"
                           href="{{ route('admin.checklist-audit.markAsUncreated', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                           onclick="event.preventDefault();document.getElementById('checklist-audit-markasuncreated-form-{{$checklistAudit->id}}').submit()"
                        ><i class="mr-2 fas fa-exclamation text-md"></i>Tandai Belum Siap Diaudit
                        </a>
                        <form id="checklist-audit-markasuncreated-form-{{ $checklistAudit->id }}"
                              class="d-none" method="POST"
                              action="{{ route('admin.checklist-audit.markAsUncreated', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                          @csrf
                          @method("PUT")
                        </form>
                      @endif
                    @endif
                  @else
                    <a class="btn btn-default text-nowrap checklist-audit-markascreated-btn"
                       data-checklist-audit="{{$checklistAudit->id}}"
                       href="{{ route('admin.checklist-audit.markAsCreated', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                       onclick="event.preventDefault();document.getElementById('checklist-audit-markascreated-form-{{$checklistAudit->id}}').submit()"
                    ><i class="mr-2 fas fa-check text-md"></i>Tandai Siap Diaudit
                    </a>
                    <form id="checklist-audit-markascreated-form-{{ $checklistAudit->id }}"
                          class="d-none" method="POST"
                          action="{{ route('admin.checklist-audit.markAsCreated', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                      @csrf
                      @method("PUT")
                    </form>
                  @endif
                </div>

                <div class="d-flex justify-content-center align-items-center" style="gap: .25rem">
                  <a class="btn btn-warning btn-sm text-nowrap"
                     href="{{ route('admin.checklist-audit.edit', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                    <i class="mr-2 fas fa-pencil-alt"></i>Edit
                  </a>
                  <a class="btn btn-danger btn-sm text-nowrap checklist-audit-delete-btn"
                     data-is-have-ptk="{{$checklistAudit->ptk !== null}}"
                     data-checklist-audit-id="{{$checklistAudit->id}}"
                     data-is-marked-as-ptk="{{$checklistAudit->is_marked_as_ptk ? 1:0}}"
                     href="{{ route('admin.checklist-audit.destroy', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}"
                  ><i class="mr-2 fas fa-trash"></i>Delete
                  </a>
                  <form id="checklist-audit-delete-form-{{ $checklistAudit->id }}"
                        class="d-none" method="POST"
                        action="{{ route('admin.checklist-audit.destroy', [$unitKerja->id, $riwayatAudit->id, $checklistAudit->id]) }}">
                    @csrf
                    @method("DELETE")
                  </form>
                </div>
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

          /*Unchecked Checklist by Auditor / Admin*/
          $('#detail-checklist-audit .checklist-audit-markasunchecked-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  if ($($el).data().isHavePtk) {
                    ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Checklist Audit ini memiliki data PTK/OAI. Apakah anda tetap ingin menandainya sebagai \"Belum Diperiksa\"?",
                    }).then((result) => {
                      if (result.isConfirmed) {
                        $(`form#checklist-audit-markasunchecked-form-${$($el).data().checklistAuditId}`).submit();
                      }
                    })
                  }
              });
          });

          /*Delete Checklist*/
          $('#detail-checklist-audit .checklist-audit-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Checklist Audit ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if ($($el).data().isMarkedAsPtk) {
                            AlertSwal2.fire({
                              icon: 'error',
                              title: 'Gagal Menghapus',
                              text: "Maaf, Anda tidak bisa menghapus checklist ini karena sedang menjadi temuan PTK/OAI.",
                            });
                          } else if ($($el).data().isHavePtk) {
                            ConfirmSwal2.fire({
                              icon: 'question',
                              title: 'Terdapat data PTK/OAI yang terhubung?',
                              text: "Sebelumnya, data checklist ini memiliki data PTK/OAI. Apakah anda ingin menghapusnya juga?",
                            }).then((result2) => {
                              if (result2.isConfirmed) {
                                $(`form#checklist-audit-delete-form-${$($el).data().checklistAuditId}`).submit();
                              }
                            })
                          } else {
                            $(`form#checklist-audit-delete-form-${$($el).data().checklistAuditId}`).submit();
                          }
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

          $('#history-checklist-audit-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });

          $('#checklist-audits-table').DataTable({
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
