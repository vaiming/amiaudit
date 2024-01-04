<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>
		@yield('title', "Cetak Checklist Audit ".$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()) | {{ config('app.name') }}
	</title>

	<style>
      table, th, td {
          border:1px solid black;
          border-collapse:collapse;
      }
      .page-break {
          page-break-after: always;
      }
	</style>
</head>
<body>
@foreach ($checklistAudits as $checklistAudit)
  @if ($loop->last)
    <div>
      <div>
        <div>
          <table style="width:100%;border:none;">
            <tbody>
            <tr>
              <td style="width:37.5%;border:none">
                <img src="{!! $logoIttp !!}" width="75" alt="Institut Teknologi Telkom Purwokerto">
              </td>
              <td style="border:none;">
                <div style="display:inline-block;text-align:center;">
                  <h2 style="font-family:'Arial Black';margin:0;font-size:1rem">
                    Form Checklist Audit
                  </h2>
                  <h1 style="font-family:'Arial Black';margin:0;font-size:1.25rem">
                    Audit Mutu Internal
                  </h1>
                  <h1 style="font-family:'Arial Black';margin:0;font-size:1.2rem">
                    {{now()->locale(config('app.locale'))->year}}
                  </h1>
                  <p style="margin:0;font-size:.75rem">
                    Institut Teknologi Telkom Purwokerto
                  </p>
                  <p style="margin:0;font-size:.75rem">
                    Jln. DI Panjaitan 128 Purwokerto
                  </p>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <section class="content" style="margin-top:1rem">
          <table style="width:100%;">
            <tbody>
            <tr>
              <td>Nomor Dokumen</td>
              <td colspan="2">{{$riwayatAudit->nomor_dokumen}}</td>
              <td>Tanggal Pembuatan</td>
              <td>{{parse_date_to_iso_format($riwayatAudit->tanggal_pembuatan)}}</td>
            </tr>
            <tr>
              <td>Status Revisi</td>
              <td colspan="2">{{$riwayatAudit->status_revisi}}</td>
              <td>Halaman</td>
              <td>{{$riwayatAudit->halaman}}</td>
            </tr>
            <tr style="border-top-width:2px;">
              <td style="border-top-width:2px;font-weight:bold;">Auditor :</td>
              <td style="border-top-width:2px;">
                @if ($riwayatAudit->auditors->isNotEmpty())
                  {{$riwayatAudit->auditors->toArray()[0]['name'] ?? '-'}}
                @else
                  -
                @endif
              </td>
              <td style="border-top-width:2px;">
                @if ($riwayatAudit->auditors->isNotEmpty())
                  {{$riwayatAudit->auditors->toArray()[1]['name'] ?? '-'}}
                @else
                  -
                @endif
              </td>
              <td style="border-top-width:2px;font-weight:bold">Tanggal :</td>
              <td style="border-top-width:2px;">{{parse_date_to_iso_format($riwayatAudit->tanggal_rencana)}}</td>
            </tr>
            <tr>
              <td style="font-weight:bold">Auditee :</td>
              <td colspan="2">
                @if ($riwayatAudit->auditee !== null)
                  {{$riwayatAudit->auditee->name}}
                @else
                  -
                @endif
              </td>
              <td style="font-weight:bold">Ruang Lingkup :</td>
              <td>
                @if ($riwayatAudit->ruang_lingkup !== null)
                  {{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold">Unit Kerja :</td>
              <td colspan="2">{{$riwayatAudit->unit_kerja->nama}}</td>
              <td rowspan="2" style="font-weight:bold">Standar Kriteria</td>
              <td rowspan="2">{{$checklistAudit->standarKriteria->nama}}</td>
            </tr>
            <tr>
              <td style="font-weight:bold">Lokasi :</td>
              <td colspan="2">{{$riwayatAudit->lokasi}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Indikator</td>
            </tr>
            <tr>
              <td>{{$checklistAudit->indikator->indikator}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Measure</td>
            </tr>
            <tr>
              <td>{{$checklistAudit->measure->measure}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Tentatif Audit Objektif/Resiko</td>
            </tr>
            <tr>
              <td>{{$checklistAudit->tentatif_audit_objektif}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Tujuan Audit</td>
            </tr>
            <tr>
              <td>{{$checklistAudit->tujuan}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Langkah Kerja</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;">
            <thead>
            <tr>
              <td style="text-align:center">No</td>
              <td style="text-align:center">Uraian Langkah Kerja</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($checklistAudit->langkah_kerja_checklists as $item)
              <tr>
                <td style="text-align:center">{{$loop->iteration}}</td>
                <td>{{ $item->langkah_kerja }}</td>
            @endforeach
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;">
            <tbody>
            <tr style="width:25%;">
              <td colspan="2" style="text-align:center;font-weight:bold">Disusun</td>
              <td colspan="2" style="text-align:center;font-weight:bold">Diperiksa</td>
            </tr>
            <tr style="width:25%;">
              <td style="font-weight:bold">Oleh Auditor</td>
              <td style="text-align:center;font-weight:bold">SAI</td>
              <td style="font-weight:bold">Oleh SAI</td>
              <td style="text-align:center;font-weight:bold">Kabag SAI</td>
            </tr>
            <tr style="width:25%;">
              <td style="font-weight:bold">Tanggal</td>
              <td style="color:white">_________</td>
              <td style="font-weight:bold">Tanggal</td>
              <td style="color:white">_______</td>
            </tr>
            <tr style="width:25%;">
              <td style="font-weight:bold;padding:2rem 0;">Paraf</td>
              <td style="font-weight:bold;padding:2rem 0;"></td>
              <td style="font-weight:bold;padding:2rem 0;">Paraf</td>
              <td style="font-weight:bold;padding:2rem 0;"></td>
            </tr>
            </tbody>
          </table>

        </section>
      </div>

      <footer class="main-footer mt-4">
        <table style="margin-top:.3rem;width:100%;border:none;">
          <tbody>
          <tr style="text-align:center">
            <td style="text-align:center;border:none;">
              <h1 style="font-family:'Arial Black';margin:0;font-size:1rem">
                Audit Mutu Internal {{now()->locale(config('app.locale'))->year}}
              </h1>
              <h1 style="font-family:'Arial Black';margin:0;font-size:1rem">
                Institut Teknologi Telkom Purwokerto
              </h1>
            </td>
          </tr>
          </tbody>
        </table>
      </footer>
    </div>
  @else
    <div class="page-break">
      <div>
        <div>
          <table style="width:100%;border:none;">
            <tbody>
            <tr>
              <td style="width:37.5%;border:none">
                <img src="{!! $logoIttp !!}" width="75" alt="Institut Teknologi Telkom Purwokerto">
              </td>
              <td style="border:none;">
                <div style="display:inline-block;text-align:center;">
                  <h2 style="font-family:'Arial Black';margin:0;font-size:1rem">
                    Form Checklist Audit
                  </h2>
                  <h1 style="font-family:'Arial Black';margin:0;font-size:1.25rem">
                    Audit Mutu Internal
                  </h1>
                  <h1 style="font-family:'Arial Black';margin:0;font-size:1.2rem">
                    {{now()->locale(config('app.locale'))->year}}
                  </h1>
                  <p style="margin:0;font-size:.75rem">
                    Institut Teknologi Telkom Purwokerto
                  </p>
                  <p style="margin:0;font-size:.75rem">
                    Jln. DI Panjaitan 128 Purwokerto
                  </p>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <section class="content" style="margin-top:1rem">
          <table style="width:100%;">
            <tbody>
            <tr>
              <td>Nomor Dokumen</td>
              <td colspan="2">{{$riwayatAudit->nomor_dokumen}}</td>
              <td>Tanggal Pembuatan</td>
              <td>{{parse_date_to_iso_format($riwayatAudit->tanggal_pembuatan)}}</td>
            </tr>
            <tr>
              <td>Status Revisi</td>
              <td colspan="2">{{$riwayatAudit->status_revisi}}</td>
              <td>Halaman</td>
              <td>{{$riwayatAudit->halaman}}</td>
            </tr>
            <tr style="border-top-width:2px;">
              <td style="border-top-width:2px;font-weight:bold;">Auditor :</td>
              <td style="border-top-width:2px;">
                @if ($riwayatAudit->auditors->isNotEmpty())
                  {{$riwayatAudit->auditors->toArray()[0]['name'] ?? '-'}}
                @else
                  -
                @endif
              </td>
              <td style="border-top-width:2px;">
                @if ($riwayatAudit->auditors->isNotEmpty())
                  {{$riwayatAudit->auditors->toArray()[1]['name'] ?? '-'}}
                @else
                  -
                @endif
              </td>
              <td style="border-top-width:2px;font-weight:bold">Tanggal :</td>
              <td style="border-top-width:2px;">{{parse_date_to_iso_format($riwayatAudit->tanggal_rencana)}}</td>
            </tr>
            <tr>
              <td style="font-weight:bold">Auditee :</td>
              <td colspan="2">
                @if ($riwayatAudit->auditee !== null)
                  {{$riwayatAudit->auditee->name}}
                @else
                  -
                @endif
              </td>
              <td style="font-weight:bold">Ruang Lingkup :</td>
              <td>
                @if ($riwayatAudit->ruang_lingkup !== null)
                  {{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold">Unit Kerja :</td>
              <td colspan="2">{{$riwayatAudit->unit_kerja->nama}}</td>
              <td rowspan="2" style="font-weight:bold">Standar Kriteria</td>
              <td rowspan="2">{{$checklistAudit->standarKriteria->nama}}</td>
            </tr>
            <tr>
              <td style="font-weight:bold">Lokasi :</td>
              <td colspan="2">{{$riwayatAudit->lokasi}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Indikator</td>
            </tr>
            <tr>
              <td>{{$checklistAudit->indikator->indikator}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Measure</td>
            </tr>
            <tr>
              <td>{{$checklistAudit->measure->measure}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Tentatif Audit Objektif/Resiko</td>
            </tr>
            <tr>
              <td>{{$checklistAudit->tentatif_audit_objektif}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Tujuan Audit</td>
            </tr>
            <tr>
              <td>{{$checklistAudit->tujuan}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Langkah Kerja</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;">
            <thead>
            <tr>
              <td style="text-align:center">No</td>
              <td style="text-align:center">Uraian Langkah Kerja</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($checklistAudit->langkah_kerja_checklists as $item)
              <tr>
                <td style="text-align:center">{{$loop->iteration}}</td>
                <td>{{ $item->langkah_kerja }}</td>
            @endforeach
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;">
            <tbody>
            <tr style="width:25%;">
              <td colspan="2" style="text-align:center;font-weight:bold">Disusun</td>
              <td colspan="2" style="text-align:center;font-weight:bold">Diperiksa</td>
            </tr>
            <tr style="width:25%;">
              <td style="font-weight:bold">Oleh Auditor</td>
              <td style="text-align:center;font-weight:bold">SAI</td>
              <td style="font-weight:bold">Oleh SAI</td>
              <td style="text-align:center;font-weight:bold">Kabag SAI</td>
            </tr>
            <tr style="width:25%;">
              <td style="font-weight:bold">Tanggal</td>
              <td style="color:white">_________</td>
              <td style="font-weight:bold">Tanggal</td>
              <td style="color:white">_______</td>
            </tr>
            <tr style="width:25%;">
              <td style="font-weight:bold;padding:2rem 0;">Paraf</td>
              <td style="font-weight:bold;padding:2rem 0;"></td>
              <td style="font-weight:bold;padding:2rem 0;">Paraf</td>
              <td style="font-weight:bold;padding:2rem 0;"></td>
            </tr>
            </tbody>
          </table>

        </section>
      </div>

      <footer class="main-footer mt-4">
        <table style="margin-top:.3rem;width:100%;border:none;">
          <tbody>
          <tr style="text-align:center">
            <td style="text-align:center;border:none;">
              <h1 style="font-family:'Arial Black';margin:0;font-size:1rem">
                Audit Mutu Internal {{now()->locale(config('app.locale'))->year}}
              </h1>
              <h1 style="font-family:'Arial Black';margin:0;font-size:1rem">
                Institut Teknologi Telkom Purwokerto
              </h1>
            </td>
          </tr>
          </tbody>
        </table>
      </footer>
    </div>
  @endif
@endforeach
</body>
</html>
