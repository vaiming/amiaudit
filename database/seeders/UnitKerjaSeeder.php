<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class UnitKerjaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $unit_kerja = [
      'UPPS' => 'UPPS',
      'PRODI' => 'Program Studi',
      'KK' => 'Kelompok Keahlian',
      'SDM' => 'Bagian Sumber Daya Manusia',
      'SPLSAI' => 'Bagian Sekretaris Pimpinan, Legal dan Satuan Audit Internal',
      'KAU' => 'Kepala Unit',
      'REKTOR' => 'Rektor',
      'WAREKI' => 'Wakil Rektor I',
      'WAREKII' => 'Wakil Rektor II',
      'DOSEN' => 'Dosen',
      'MHS' => 'Mahasiswa',
      'LPPM' => 'LPPM',
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

    foreach ($unit_kerja as $key => $value) {
      UnitKerja::create(['kode' => $key, 'nama' => $value]);
    }
  }
}
