<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>
		@yield('title', "Cetak Rencana Audit ".$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()) | {{ config('app.name') }}
	</title>

	<style>
      table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
      }
	</style>
</head>
<body>
<div>
	<div>
		<div>
			<table style="width:100%;border:none">
				<tbody>
				<tr>
					<td style="width:37.5%;border:none">
						<img src="{!! $logoIttp !!}" width="75" alt="Institut Teknologi Telkom Purwokerto">
					</td>
					<td style="border:none;">
						<div style="display:inline-block;text-align: center;">
							<h2 style="font-family: 'Arial Black';margin:0;font-size: 1rem">
								Form Rencana Audit
							</h2>
							<h1 style="font-family: 'Arial Black';margin:0;font-size: 1.25rem">
								Audit Mutu Internal
							</h1>
							<h1 style="font-family: 'Arial Black';margin:0;font-size: 1.2rem">
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
					<td style="border-top-width:2px;font-weight: bold">Tanggal :</td>
					<td style="border-top-width:2px;">{{parse_date_to_iso_format($riwayatAudit->tanggal_rencana)}}</td>
				</tr>
				<tr>
					<td style="font-weight: bold">Auditee :</td>
					<td colspan="2">
						@if ($riwayatAudit->auditee !== null)
							{{$riwayatAudit->auditee->name}}
						@else
							-
						@endif
					</td>
					<td style="font-weight: bold">Ruang Lingkup :</td>
					<td>
						@if ($riwayatAudit->ruang_lingkup !== null)
							{{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()}}
						@else
							-
						@endif
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold">Unit Kerja :</td>
					<td colspan="2">{{$riwayatAudit->unit_kerja->nama}}</td>
					<td rowspan="2"></td>
					<td rowspan="2"></td>
				</tr>
				<tr>
					<td style="font-weight: bold">Lokasi :</td>
					<td colspan="2">{{$riwayatAudit->lokasi}}</td>
				</tr>
				</tbody>
			</table>

			<table style="margin-top:.15rem;width:100%;">
				<thead>
				<tr>
					<td style="text-align: center">Sub Unit Kerja</td>
					<td style="text-align: center">Auditor</td>
					<td style="text-align: center">Auditee</td>
					<td style="text-align: center">Dokumen</td>
				</tr>
				</thead>
				<tbody>
				@foreach ($rencanaAudits as $item)
					<tr>
						<td>{{ $item->sub_unit_kerja }}</td>
						<td>
							@if ($item->auditor)
								{{$item->auditor->name}}
							@else
								<div style="text-align: center">-</div>
							@endif
						</td>
						<td>
							@if ($item->auditee)
								{{$item->auditee->name}}
							@else
								<div style="text-align: center">-</div>
							@endif
						</td>
						<td>{{ $item->dokumen }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>

		</section>
	</div>

	<footer class="main-footer mt-4">
    <table style="margin-top:.3rem;width: 100%; border: none">
      <tbody>
      <tr style="text-align: center">
        <td style="text-align: center; border: none">
          <h1 style="font-family: 'Arial Black';margin:0;font-size: 1rem">
            Audit Mutu Internal {{now()->locale(config('app.locale'))->year}}
          </h1>
          <h1 style="font-family: 'Arial Black';margin:0;font-size: 1rem">
            Institut Teknologi Telkom Purwokerto
          </h1>
        </td>
      </tr>
      </tbody>
    </table>
	</footer>
</div>
</body>
</html>
