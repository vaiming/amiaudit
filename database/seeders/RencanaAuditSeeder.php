<?php

namespace Database\Seeders;

use App\Models\Auditee;
use App\Models\RencanaAudit;
use App\Models\RiwayatAudit;
use App\Models\RuangLingkup;
use App\Models\StandarKriteria;
use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class RencanaAuditSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $rencanaAudits = [
      'UPPS' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'PRODI' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'KK' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'SDM' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'SPLSAI' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'KAU' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'REKTOR' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'WAREKI' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'WAREKII' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'DOSEN' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'MHS' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
      'LPPM' => [
        '20202021|GANJIL',
        '20202021|GENAP',
        '20212022|GANJIL',
        '20212022|GENAP',
      ],
    ];

    $temp = [
      'TRVIEW' => 'Tim Reviewer',
      'SINO' => 'Sentra Inovasi',
      'KMK' => 'Koordinator Mata Kuliah',
      'PKA' => 'Pengembangan Karir dan Alumni',
      'PLULUS' => 'Pengguna Lulusan',
      'ALUMNI' => 'Alumni',
      'STKHOLDER' => 'Stakeholder',
      'SPMPPP' => 'Bagian Satuan Penjaminan Mutu dan Perencanaan Pengembangan Pembelajaran',
      'KAPRODI' => 'Ketua Program Studi',
      'ITS' => 'Bagian IT Support',
      'HKKUI' => 'Bagian Humas Kerjasama dan Kantor Urusan Internasional',
      'PAKA' => 'Pelayanan Akademik',
      'UAKA' => 'Urusan Akademik',
      'AKAFAK' => 'Akademik Fakultas',
      'KAURLAB' => 'Kepala Urusan Laboratorium',
      'UPP' => 'Urusan Pengembangan Pembelajaran',
      'MHSN' => 'Bagian Kemahasiswaan',
      'KUAN' => 'Bagian Keuangan',
      'PEAD' => 'Bagian Pemasaran dan Admisi',
      'URPERPUS' => 'Urusan Perpustakaan',
      'LMA' => 'Bagian Logistik dan Manajemen Aset',
      'GJMPROD' => 'Gugus Jaminan Mutu Program Studi',
      'KSAMA' => 'Kerjasama',
      'PREN' => 'Perencanaan',
      'IA' => 'Internal Audit',
      'KESKEM' => 'Kesejahteraan Kemahasiswaan',
      'BK' => 'Bimbingan dan Konseling',
      'SUKS' => 'Seluruh Unit yang melakukan Kerjasama',
      'CDC' => 'Carrier Development Center (CDC)',
      'ASOSIASI' => 'Asosiasi',
      'INDUSTRI' => 'Industri',
      'PERMEN' => 'Pemerintahan',
      'MITRA' => 'Mitra'
    ];

    foreach ($rencanaAudits as $unitKerjaId => $ruangLingkups) {
      foreach ($ruangLingkups as $item) {
        // Find ruang lingkup by tahun ajaran and semester
        $ruangLingkup = RuangLingkup::where(
          'tahun_ajaran_mulai', \Str::substr(\Str::before($item, '|'), 0, 4)
        )
          ->where('tahun_ajaran_selesai', \Str::substr(\Str::before($item, '|'), 4, 4))
          ->where('semester', strtolower(\Str::after($item, '|')))
          ->get()->first();

        $unitKerja = UnitKerja::where( 'kode', $unitKerjaId)->first();
        $riwayatAudit = RiwayatAudit::where('unit_kerja_id', $unitKerja->id)
          ->where('ruang_lingkup_id', $ruangLingkup->id)
          ->get()->first();

        $auditees = Auditee::where('unit_kerja_id', $unitKerja->id)->get();
        $auditors = $riwayatAudit->auditors;
        $standarKriteria = StandarKriteria::get();

        RencanaAudit::factory(5)->create([
          'auditee_id' => $auditees->random()->id,
          'auditor_id' => $auditors->random()->id,
          'standar_kriteria_id' => $standarKriteria->random()->id,
          'riwayat_audit_id' => $riwayatAudit->id,
        ]);
      }
    }
  }
}
