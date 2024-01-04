<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>
		@yield('title', "Cetak PTK/OAI ".$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()) | {{ config('app.name') }}
	</title>

	<style>
      table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
      }
      .page-break {
          page-break-after: always;
      }
	</style>
</head>
<body>
@foreach ($ptks as $ptk)
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
                <div style="display:inline-block;text-align: center;">
                  <h2 style="font-family: 'Arial Black';margin:0;font-size:1rem">
                    Permintaan Tindakan Koreksi
                  </h2>
                  <h1 style="font-family: 'Arial Black';margin:0;font-size:1.25rem">
                    Audit Mutu Internal
                  </h1>
                  <h1 style="font-family: 'Arial Black';margin:0;font-size:1.2rem">
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

        <section class="content" style="margin-top: 1rem">
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
              <td style="border-top-width:2px;font-weight:bold;">Auditor</td>
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
              <td style="font-weight:bold">Auditee</td>
              <td colspan="2">
                @if ($riwayatAudit->auditee !== null)
                  {{$riwayatAudit->auditee->name}}
                @else
                  -
                @endif
              </td>
              <td style="font-weight:bold">Ruang Lingkup</td>
              <td>
                @if ($riwayatAudit->ruang_lingkup !== null)
                  {{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold">Unit Kerja</td>
              <td colspan="2">{{$riwayatAudit->unit_kerja->nama}}</td>
              <td rowspan="2" style="font-weight:bold">Standar Kriteria</td>
              <td rowspan="2">{{$ptk->checklist_audit->standarKriteria->nama}}</td>
            </tr>
            <tr>
              <td style="font-weight:bold">Lokasi</td>
              <td colspan="2">{{$riwayatAudit->lokasi}}</td>
            </tr>
            <tr>
              <td style="font-weight:bold">Temuan Klausul ISO 21001:2018</td>
              <td colspan="2">5.1.2</td>
              <td style="font-weight:bold">Temuan PTK/OAI</td>
              <td>{{$ptk->type}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Deskripsi Ketidaksesuaian</td>
            </tr>
            <tr>
              <td style="width: 30%">Problem</td>
              <td>{{ $ptk->problem }}</td>
            </tr>
            <tr>
              <td style="width: 30%">Location</td>
              <td>{{ $ptk->location }}</td>
            </tr>
            <tr>
              <td style="width: 30%">Objective</td>
              <td>{{ $ptk->objective }}</td>
            </tr>
            <tr>
              <td style="width: 30%">Reference</td>
              <td>{{ $ptk->reference }}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;">
            <tbody>
            <tr>
              <td style="text-align:center;font-weight:bold"
              >Tanda Tangan Auditor</td>
              <td style="text-align:center;font-weight:bold"
              >Tanda Tangan Auditee</td>
            </tr>
            <tr>
              <td style="text-align:center;font-weight:bold; padding: 2rem 0;"></td>
              <td style="text-align:center;font-weight:bold; padding: 2rem 0;"></td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Analisa Akar Masalah</td>
            </tr>
            <tr>
              <td>{{$ptk->analisa_akar_masalah}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Akibat</td>
            </tr>
            <tr>
              <td>{{$ptk->akibat}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Rekomendasi/Permintaan Tindakan Koreksi</td>
            </tr>
            <tr>
              <td>{{$ptk->permintaan_tindakan_koreksi}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Rencana Tindakan Perbaikan</td>
            </tr>
            <tr>
              <td>{{$ptk->rencana_tindakan_perbaikan}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Rencana Pencegahan</td>
            </tr>
            <tr>
              <td>{{$ptk->rencana_pencegahan}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="width:30%;border:none;font-weight:bold;white-space:nowrap!important;">
                Waktu Perbaikan
              </td>
              <td style="border:none;white-space:nowrap!important;">
                : {{parse_date_to_iso_format($ptk->repairing_datetime_finish)}}
              </td>
            </tr>
            <tr>
              <td style="width:30%;border:none;font-weight:bold;white-space:nowrap!important;">
                Penanggung Jawab Perbaikan
              </td>
              <td style="border:none;white-space:nowrap!important;">
                : {{$ptk->penanggungJawabPerbaikan->nama}}
              </td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.15rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td colspan="3" style="width:50%;border:none;white-space:nowrap!important;"></td>
              <td colspan="3" style="width:50%;border:none;font-weight:bold;white-space:nowrap!important;">
                Mengetahui
              </td>
            </tr>
            <tr>
              <td style="width:10%;border:none;font-weight:bold;white-space:nowrap!important;">
                Auditee
              </td>
              <td colspan="2" style="width:40%;border:none;">
                : {{ $ptk->auditee->name }}
              </td>
              <td style="width:10%;border:none;font-weight:bold;white-space:nowrap!important;">
                Auditor
              </td>
              <td colspan="2" style="width:40%;border:none;">
                : {{ $ptk->auditor->name }}
              </td>
            </tr>
            <tr>
              <td colspan="3" style="width:50%;text-align:center;font-weight:bold"
              >Tanda Tangan Auditee</td>
              <td colspan="3" style="width:50%;text-align:center;font-weight:bold"
              >Tanda Tangan Auditor</td>
            </tr>
            <tr>
              <td colspan="3" style="width:50%;padding:2rem 0;"></td>
              <td colspan="3" style="width:50%;padding:2rem 0;"></td>
            </tr>
            </tbody>
          </table>
        </section>
      </div>

      <footer class="main-footer mt-4">
        <table style="margin-top:.3rem;width:100%;border:none;">
          <tbody>
          <tr style="text-align: center">
            <td style="text-align: center; border:none;">
              <h1 style="font-family: 'Arial Black';margin:0;font-size:1rem">
                Audit Mutu Internal {{now()->locale(config('app.locale'))->year}}
              </h1>
              <h1 style="font-family: 'Arial Black';margin:0;font-size:1rem">
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
                <div style="display:inline-block;text-align: center;">
                  <h2 style="font-family: 'Arial Black';margin:0;font-size:1rem">
                    Permintaan Tindakan Koreksi
                  </h2>
                  <h1 style="font-family: 'Arial Black';margin:0;font-size:1.25rem">
                    Audit Mutu Internal
                  </h1>
                  <h1 style="font-family: 'Arial Black';margin:0;font-size:1.2rem">
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

        <section class="content" style="margin-top: 1rem">
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
              <td style="border-top-width:2px;font-weight:bold;">Auditor</td>
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
              <td style="font-weight:bold">Auditee</td>
              <td colspan="2">
                @if ($riwayatAudit->auditee !== null)
                  {{$riwayatAudit->auditee->name}}
                @else
                  -
                @endif
              </td>
              <td style="font-weight:bold">Ruang Lingkup</td>
              <td>
                @if ($riwayatAudit->ruang_lingkup !== null)
                  {{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold">Unit Kerja</td>
              <td colspan="2">{{$riwayatAudit->unit_kerja->nama}}</td>
              <td rowspan="2" style="font-weight:bold">Standar Kriteria</td>
              <td rowspan="2">{{$ptk->checklist_audit->standarKriteria->nama}}</td>
            </tr>
            <tr>
              <td style="font-weight:bold">Lokasi</td>
              <td colspan="2">{{$riwayatAudit->lokasi}}</td>
            </tr>
            <tr>
              <td style="font-weight:bold">Temuan Klausul ISO 21001:2018</td>
              <td colspan="2">5.1.2</td>
              <td style="font-weight:bold">Temuan PTK/OAI</td>
              <td>{{$ptk->type}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Deskripsi Ketidaksesuaian</td>
            </tr>
            <tr>
              <td style="width: 30%">Problem</td>
              <td>{{$ptk->problem}}</td>
            </tr>
            <tr>
              <td style="width: 30%">Location</td>
              <td>{{$ptk->location}}</td>
            </tr>
            <tr>
              <td style="width: 30%">Objective</td>
              <td>{{$ptk->objective}}</td>
            </tr>
            <tr>
              <td style="width: 30%">Reference</td>
              <td>{{$ptk->reference}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;">
            <tbody>
            <tr>
              <td style="text-align:center;font-weight:bold"
              >Tanda Tangan Auditor</td>
              <td style="text-align:center;font-weight:bold"
              >Tanda Tangan Auditee</td>
            </tr>
            <tr>
              <td style="text-align:center;font-weight:bold; padding: 2rem 0;"></td>
              <td style="text-align:center;font-weight:bold; padding: 2rem 0;"></td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Analisa Akar Masalah</td>
            </tr>
            <tr>
              <td>{{$ptk->analisa_akar_masalah}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Akibat</td>
            </tr>
            <tr>
              <td>{{$ptk->akibat}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Rekomendasi/Permintaan Tindakan Koreksi</td>
            </tr>
            <tr>
              <td>{{$ptk->permintaan_tindakan_koreksi}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Rencana Tindakan Perbaikan</td>
            </tr>
            <tr>
              <td>{{$ptk->rencana_tindakan_perbaikan}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="font-weight:bold;border:none;">Rencana Pencegahan</td>
            </tr>
            <tr>
              <td>{{$ptk->rencana_pencegahan}}</td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.3rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td style="width: 30%;border:none;font-weight:bold;white-space:nowrap!important;">
                Waktu Perbaikan
              </td>
              <td style="border:none;white-space:nowrap!important;">
                : {{ parse_date_to_iso_format($ptk->repairing_datetime_finish)}}
              </td>
            </tr>
            <tr>
              <td style="width: 30%;border:none;font-weight:bold;white-space:nowrap!important;">
                Penanggung Jawab Perbaikan
              </td>
              <td style="border:none;white-space:nowrap!important;">
                : {{ $ptk->penanggungJawabPerbaikan->nama}}
              </td>
            </tr>
            </tbody>
          </table>

          <table style="margin-top:.15rem;width:100%;border:none;">
            <tbody>
            <tr>
              <td colspan="3" style="width:50%;border:none;white-space:nowrap!important;"></td>
              <td colspan="3" style="width:50%;border:none;font-weight:bold;white-space:nowrap!important;">
                Mengetahui
              </td>
            </tr>
            <tr>
              <td style="width:10%;border:none;font-weight:bold;white-space:nowrap!important;">
                Auditee
              </td>
              <td colspan="2" style="width:40%;border:none;">
                : {{ $ptk->auditee->name }}
              </td>
              <td style="width:10%;border:none;font-weight:bold;white-space:nowrap!important;">
                Auditor
              </td>
              <td colspan="2" style="width:40%;border:none;">
                : {{ $ptk->auditor->name }}
              </td>
            </tr>
            <tr>
              <td colspan="3" style="width:50%;text-align:center;font-weight:bold"
              >Tanda Tangan Auditee</td>
              <td colspan="3" style="width:50%;text-align:center;font-weight:bold"
              >Tanda Tangan Auditor</td>
            </tr>
            <tr>
              <td colspan="3" style="width:50%;padding:2rem 0;"></td>
              <td colspan="3" style="width:50%;padding:2rem 0;"></td>
            </tr>
            </tbody>
          </table>
        </section>
      </div>

      <footer class="main-footer mt-4">
        <table style="margin-top:.3rem;width:100%;border:none;">
          <tbody>
          <tr style="text-align: center">
            <td style="text-align: center; border:none;">
              <h1 style="font-family: 'Arial Black';margin:0;font-size:1rem">
                Audit Mutu Internal {{now()->locale(config('app.locale'))->year}}
              </h1>
              <h1 style="font-family: 'Arial Black';margin:0;font-size:1rem">
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
