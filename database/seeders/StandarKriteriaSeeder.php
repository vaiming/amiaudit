<?php

namespace Database\Seeders;

use App\Models\Indikator;
use App\Models\Measure;
use App\Models\PernyataanStandar;
use App\Models\PernyataanStandarUnitKerja;
use App\Models\StandarKriteria;
use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class StandarKriteriaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $standarKriteriaPembelajaran = [
      'Standar Dosen dan Tenaga Kependidikan'
      => [
        'Dosen memiliki kualifikasi akademik dan kompetensi pendidik, serta memiliki kemampuan untuk menyelenggarakan pendidikan yang relevan dengan Program Studi terkait'
        => [
          [
            'Kualifikasi akademik minimal S2 relevan dengan program studi terkait',
            'Terdapat peningkatan jabatan fungsional Dosen sesuai dengan masa kerja minimal yang ditetapkan',
            'Terdapat Dosen tetap yang memperoleh Sertifikasi dosen setiap tahunnya',
            'Terdapat peningkatan jumlah dosen tetap dengan kualifikasi akademik S3',
          ],
          [
            'Memverifikasi  kompetensi Dosen dengan mata kuliah yang diampu',
            'Melakukan evaluasi Dosen dengan jabatan fungsional akademik',
            'Melakukan evaluasi Dosen yang memiliki sertifikasi dosen',
            'Melakukan evaluasi jumlah Dosen yang memiliki kualifikasi akademik S3',
          ],
          [
            'UPPS',
            'PRODI',
            'KK',
            'SDM',
          ]
        ],
        'Program Studi harus menetapkan Beban Kerja Dosen dengan memperhatikan kegiatan pokok dosen yang meliputi : a) Perencanaan, Pelaksanaan dan Pengendalian Proses Pembelajaran; Pelaksanaan evaluasi hasil pembelajaran; Pembimbingan dan Pelatihan; Penelitian dan Pengabdian Masyarakat, b) kegiatan tambahan dan c) kegiatan penunjang'
        => [
          [
            'Rata-rata beban kerja Dosen  12-16 sks',
            'Rasio Dosen Tetap Program Studi (DTPS) terhadap Mahasiswa sebesar 1:25',
            'Jumlah Dosen Tidak Tetap (DLB) terhadap jumlah DTPS <= 10%',
            'Jumlah Bimbingan Tugas Akhir Mahasiswa per Dosen maksimal 20 mahasiswa',
          ],
          [
            'Menghitung rata-rata beban kerja dosen',
            'Menghitung jumlah DTPS dan student body mahasiswa',
            'Membandingkan jumlah DLB dengan DTPS',
            'Menghitung jumlah bimbingan mahasiswa per dosen',
          ],
          [
            'UPPS',
            'PRODI',
            'SDM',
          ]
        ],
      ], //1
      'Standar Isi Pembelajaran'
      => [
        'Program Studi bertanggung jawab menyusun kurikulum dimana penyusunan kerangka dasar, struktur kurikulum, beban belajar sesuai dengan peraturan, serta capaian pembelajaran dengan profil lulusan, jenjang KKNI/SKKNI dan visi misi ITTP serta dimutakhirkan secara berkala, minor setiap 1 tahun dan mayor setiap 4 tahun sesuai perkembangan ipteks dan kebutuhan pengguna dengan melibatkan pemangku kepentingan internal dan eksternal'
        => [
          [
            'Terdapat pemetaan Capaian Pembelajaran Lulusan (CPL) ke Capaian Pembelajaran Matakuliah (CPMK)',
            'Terdapat kurikulum program studi sesuai profil lulusan, jenjang KKNI/SKKNI dan visi misi ITTP',

            //Asosiasi
            'Terdapat kesesuaian matakuliah program studi yang merujuk pada kurikulum inti dari asosiasi penyelenggara program studi sejenis dan organisasi profesi',

            'Persentase matakuliah yang dalam penentuan nilai akhirnya memberikan bobot pada tugas-tugas > 20% lebih dari 60%',
            'Persentase matakuliah dilengkapi dengan deskripsi matakuliah, silabus dan RPS lebih dari 90%',
          ],
          [
            'Melakukan analisis ketercapaian matakuliah sesuai dengan KKNI dan visi ITTP',
            'Melakukan evaluasi proporsi matakuliah program studi',
          ],
          [
            'PRODI',
            'UPPS',
            'WAREKI',
            'DOSEN',
            'ASOSIASI',
            'INDUSTRI',
            'PERMEN',
            'ALUMNI',
            'MHS',
          ]
        ],

      ], //2
      'Standar Kompetensi Lulusan'
      => [
        'Program Studi memiliki kompetensi lulusan sesuai dengan visi ITTP yang diturunkan ke visi Fakultas yaitu dapat mengembangkan ilmu pengetahuan berbasis teknologi informasi dengan keunggulan pada bidang Healthcare, Agro-Industry, Tourism, dan Small Medium Enterprise'
        => [
          [
            'Seluruh program studi memiliki kompetensi lulusan yang terkait visi ITTP, Fakultas dan Program Studi yang dicantumkan dalam dokumen kurikulum',
            'Seluruh program studi memiliki profil lulusan yang berkarakter unggul tertuang dalam dokumen standar kualitas lulusan.',
          ],
          [
            'Melakukan survei pengguna lulusan dan alumni dengan minimal 50% respon dari populasi (TS-2 s.d. TS-4)',
          ],
          [
            'PRODI',
            'UPPS',
            'PKA',
            'PLULUS',
            'ALUMNI',
          ]
        ],
        'Program Studi memiliki kompetensi lulusan yang sesuai jenjang level KKNI, SNPT, dan standar internasional yang berlaku 5 tahun sekali dan dievaluasi minimal 1 tahun sekali dengan melibatkan masukan dari pengguna alumni'
        => [
          [
            'Semua program studi memiliki kompetensi lulusan sesuai dengan jenjang level KKNI, SNPT, dan standar internasional '
          ],
          [
            'Melakukan survei kompetensi lulusan yang berlaku dengan melibatkan pengguna alumni',
            'Melakukan review kompetensi lulusan yang berlaku dengan melibatkan masukan dari pengguna alumni',
          ],
          [
            'PRODI',
            'UPPS',
            'PKA',
            'PLULUS',
            'ALUMNI',
          ]
        ],
        'Program Studi menetapkan capaian pembelajaran sesuai dengan rumusan sikap, pengetahuan, keterampilan umum dan keterampilan khusus serta profil lulusan yang menggambarkan  kebutuhan pengguna lulusan minimal setiap 5 tahun sekali dan dievaluasi setiap tahunnya.'
        => [
          [
            'Capaian pembelajaran program studi telah mencakup semua aspek yaitu sikap, pengetahuan, keterampilan umum dan keterampilan khusus  dan kesesuaian profil lulusan sesuai dengan kebutuhan pengguna lulusan',
          ],
          [
            'Melakukan checklist rubrik capaian pembelajaran dengan aspek sikap, pengetahuan, keterampilan umum dan keterampilan khusus',
            'Mengumpulkan masukan kebutuhan dari pengguna lulusan',
          ],
          [
            'PRODI',
            'UPPS',
            'PKA',
            'STKHOLDER',
          ]
        ],

        // P Karir & Alumni && KAPRODI
        'Bagian Pengembangan Karir dan Alumni secara sistematis melakukan penelusuran lulusan, survei kepuasan lulusan dan  survei kepuasan pengguna lulusan yang dilakukan setiap tahun.'
        => [
          [
            'Terdapat modul sistem Informasi penelusuran lulusan',
            'Hasil survei kepuasan lulusan dengan hasil  minimal 80%.',
          ],
          [
            'Melakukan survei setiap 1 tahun sekali terkait kepuasan lulusan terhadap institusi',
            'Melakukan survei setiap 1 tahun sekali terkait kepuasan pengguna lulusan',
          ],
          [
            'PKA',
            'KAPRODI',
            'ITS',
          ]
        ],

        // B. SPM, PPP
        'Bagian Satuan Penjaminan Mutu, Perencanaan dan Pengembangan Pembelajaran melakukan pengukuran dan evaluasi capaian pembelajaran secara sistematis setiap tahun dengan mempertimbangkan hasil capaian pembelajaran.'
        => [
          [
            'Mengukur Kepuasan Evaluasi Dosen oleh Mahasiswa (EDOM)  minimal 80% dilaksanakan 2 kali (UTS dan UAS) dalam 1 semester',
            'Capaian pembelajaran telah ditetapkan di Rencana Pembelajaran Semester',
          ],
          [
            'Melakukan survei pengukuran capaian pembelajaran pada EDOM',
            'Checklist rubrik capaian pembelajaran dengan RPS',
          ],
          [
            'SPMPPP',
            'PRODI',
          ]
        ],

        // IT SUpport
        'Institusi mengeluarkan Surat Keterangan Pendamping Ijazah (SKPI) bagi tiap lulusan setiap tahunnya.'
        => [
          [
            '100% Lulusan yang diwisuda memiliki SKPI',
            '100% Lulusan memiliki Transkrip Akademik Kemahasiswaan (TAK)',
            'Program studi  mengisi sikap, pengetahuan, keterampilan umum, dan keterampilan khusus dari transkrip dan capaian pembelajaran mahasiswa',
          ],
          [
            'Sinkronisasi data akademik ITTP ke sistem informasi SKPI',
            'Lulusan mengisi TAK untuk isian SKPI',
          ],
          [
            'PRODI',
            'PAKA',
            'ITS',
            'MHSN',
          ]
        ],

        // P Akademik
        'Program studi mewajibkan mahasiswa memiliki minimal satu sertifikat bahasa Inggris sebagai syarat kelulusan.'
        => [
          [
            'Nilai TOEFL minimal 400 atau TOEIC minimal 345 sebagai syarat kelulusan atau setara dengan bahasa asing lainnya',
            'Kesesuaian dengan jumlah angkatan dengan jumlah sertifikasi TOEFL (100%)',
          ],
          [
            'Menyelenggarakan sertifikasi Bahasa TOEFL',
          ],
          [
            'PRODI',
            'PAKA',
          ]
        ],
      ], //3
      'Standar Pembiayaan Pembelajaran'
      => [
        'Wakil Rektor II bidang Sumber Daya bertanggung jawab mengalokasikan biaya operasional pendidikan sebesar 15 juta per mahasiswa per tahun'
        => [
          [
            'Adanya Rencana Kerja Anggaran (RKA) Prodi pada bulan ke-12 atau N-1 yang bisa diakses setiap Prodi.',
            'Adanya laporan realisasi anggaran yang tepat waktu, tepat program dan tepat anggaran',
            'Adanya laporan evaluasi bulanan keterserapan anggaran minimal 1x setiap bulan.',
          ],
          [
            'Melakukan monitoring dan evaluasi data anggaran biaya pendidikan melalui sistem informasi keuangan',
            'Membandingkan Daftar Rencana Kerja (DRK) dalam RKA dengan kegiatan yang direalisasikan.',
            'Membandingkan Realisasi dengan Perencanaan program kerja',
            'Menghitung total pemakaian dana untuk kegiatan pendidikan dalam setahun dibagi dengan total Jumlah Mahasiswa.',
          ],
          [
            'WAREKII',
            'UPPS',
            'PRODI',
            'KUAN',
            'PAKA',
            //'KAU', //? Seluruh Kepala Bagian dan jajarannya
          ]
        ],

        // Keuangan
        'Wakil Rektor II bidang Sumber Daya bertanggungjawab pada realisasi investasi (SDM, sarana dan prasarana) yang mendukung penyelenggaraan tridharma dan dimutakhirkan secara berkala 1 tahun sekali'
        => [
          [
            'Terdapat rencana investasi (SDM, sarana dan prasarana) untuk memenuhi kebutuhan akan penyelenggaraan program pendidikan, penelitian dan PKM.',
            'Tersedianya dokumen aset sarana dan prasarana terkini',
          ],
          [
            'Menghitung realisasi investasi dalam waktu 1 tahun dibandingkan dengan rencana kerja anggaran investasi pada tahun tersebut',
            'Melakukan monitoring dan evaluasi perkembangan realisasi investasi.',
            'Melakukan monitoring pencatatan investasi secara berkala',
          ],
          [
            'WAREKII',
            'KUAN',
            'LMA',
            'SDM',
          ]
        ],

      ], //4
      'Standar Pengelolaan Pembelajaran'
      => [
        'Rektor harus memiliki kebijakan, rencana strategis, sedangkan Unit Pengelola Program Studi (UPPS) dan Program Studi memiliki rencana operasional terkait dengan pembelajaran yang dapat diakses oleh civitas akademika dan pemangku kepentingan, serta dijadikan pedoman bagi program studi dalam melaksanakan pembelajaran sehingga dapat menghasilkan program pembelajaran yang berdaya saing nasional dan internasional'
        => [
          [
            'Terdapat kebijakan pembelajaran dan Rencana Strategis (Renstra) pada level institusi yang menjadi pedoman fakultas dan program studi',
            'Tersedianya sistem informasi yang memuat rencana operasional pembelajaran yang dapat diakses oleh civitas akademika',
            'Tersedianya laporan hasil survei dan evaluasi Renstra sesuai dengan periode yang ditetapkan',
          ],
          [
            'Melakukan survei visi misi tujuan sasaran (VMTS)',
            'Melakukan survei kepuasan mahasiswa terhadap sarana dan prasarana',
            'Melakukan survei kepuasan mahasiswa terhadap pembelajaran daring',
            'Melakukan survei Evaluasi Dosen Oleh Mahasiswa (EDOM)',
            'Melakukan survei kepuasan mahasiswa terhadap pembimbingan tugas akhir',
            'Melakukan survei kepuasan pengguna alumni',
            'Melakukan evaluasi Renstra',
            'Melakukan Audit Internal secara periodik (1 kali dalam setahun)',
          ],
          [
            'REKTOR',
            'WAREKI',
            'UPPS',
            'PRODI',
            'PKA', //? Pengembangan Karir dan Konseling
            'SPMPPP',
            'SPLSAI'
          ]
        ],
        'UPPS dan program studi melaksanakan pembelajaran sesuai dengan jenis pendidikan baik dari segi kompetensi dan kualifikasi dosen, sarana, proses pembelajaran, dan sistem informasi akademik'
        => [
          [
            'Terdapat kesesuaian kompetensi dan kualifikasi dosen dengan mata kuliah yang diampu',
            'Tersedianya sarana pembelajaran setiap program studi',
            'Tersedianya modul perkuliahan pada sistem informasi akademik ',
          ],
          [
            'Melakukan rekrutmen dosen matakuliah yang sesuai',
            'Melakukan evaluasi berdasarkan survei kepuasan mahasiswa terhadap sarana pembelajaran',
            'Melakukan audit sistem informasi akademik',
          ],
          [
            'UPPS',
            'PRODI',
            'ITS',
            'LMA',
            'SPLSAI'
          ]
        ],
        'Wakil Rektor I bidang Akademik dan Riset harus mengendalikan dan meningkatkan secara berkelanjutan terpenuhinya target lulusan tepat waktu.'
        => [
          [
            'Terdapat pedoman skripsi dan tugas akhir yang dapat diakses secara online seluruh mahasiswa',
            'Terdapat sistem informasi yang mendukung proses pelaksanaan skripsi dan tugas akhir',
            //P Akademik
            'Terdapat sistem informasi yang mendukung sistem perwalian',
            'Persentase kelulusan tepat waktu program Diploma Tiga > 70% setiap tahun masuk angkatan',
            'Persentase kelulusan tepat waktu program Sarjana > 50%'
          ],
          [
            'Melakukan evaluasi tingkat 1 tahun sekali disetiap akhir tahun akademik',
            'Melakukan survei kepuasan proses tugas akhir',
            'Melakukan monitoring bimbingan tugas akhir melalui logbook pada modul TA/PA sistem informasi akademik',
          ],
          [
            'WAREKI',
            'UPPS',
            'PRODI',
            "PAKA",
          ]
        ],
        'UPPS harus menyelenggarakan pelatihan  bagi Dosen dan Tenaga Penunjang Akademik (TPA) berkaitan dengan proses pembelajaran dalam rangka peningkatan mutu pembelajaran program studi'
        => [
          [
            'Terdapat dokumen Rencana Pengembangan Kompetensi Dosen dan TPA',
            'Terdapat laporan kegiatan pelatihan',
            'Terdapat kegiatan ToT bagi Dosen dan TPA yang telah melaksanakan pelatihan',
          ],
          [
            'Melaksanakan evaluasi pelaksanaan pelatihan Dosen dan TPA',
            'Dosen dan TPA yang tersertifikasi',
            'Melaksanakan ToT yang diikuti oleh Dosen dan TPA',
          ],
          [
            'UPPS',
            'PRODI',
            'SDM',
          ]
        ],
        'UPPS harus memiliki panduan penyusunan kurikulum, panduan pembelajaran (Perkuliahan, praktikum, dan ujian), dan dokumen evaluasi pembelajaran yang terdokumentasi, dokumen penjaminan mutu, dokumen pengembangan pembelajaran dengan baik dan dilaksanakan dengan konsisten dan didukung dengan sistem informasi yang memadai'
        => [
          [
            'Adanya dokumen panduan penyusunan kurikulum',
            'Adanya dokumen panduan pembelajaran',
            'Adanya dokumen laporan proses dan evaluasi pembelajaran',
          ],
          [
            'Melakukan evaluasi kurikulum: Melakukan survei kepuasan pengguna lulusan dan masukan dari stakeholder; dan Evaluasi kurikulum mengacu pada standar SNPT dan standar internasional seperti ACM, IEEE, ABET, IABEE, JABEE, atau lainnya.',
            'Melakukan monitoring dan evaluasi pembelajaran dari UPPS ke program studi di setiap akhir semester',
            'Melakukan rolling out Renstra berdasarkan Indikator Kinerja Utama (IKU) Merdeka Belajar Kampus Merdeka (MBKM) setiap akhir tahun akademik',
          ],
          [
            'UPPS',
            'WAREKI',
            'PRODI',
            'SPMPPP',
            'PAKA',
            'PKA' //? Bagian Pengembangan Karir dan Konseling
          ]
        ],
        'Program studi melakukan evaluasi kurikulum berdasarkan analisis internal, tracer studi, market signal, referensi perkembangan ilmu pengetahuan dan teknologi, evaluasi kurikulum yang telah dilaksanakan dan dimutakhirkan 4 s.d. 5 tahun sekali'
        => [
          [
            'Terdapat laporan tracer studi yang diterima program studi disetiap tahunnya',
            'Terdapat dokumen analisis market signal dan diupdate setiap tahun',
            'Adanya laporan proses pembelajaran',
            'Adanya dokumen evaluasi pembelajaran',
          ],
          [
            'Melakukan evaluasi kurikulum: Melakukan survei kepuasan pengguna lulusan dan masukan dari stakeholder; dan Evaluasi kurikulum mengacu pada standar SNPT dan standar internasional seperti ACM, IEEE, ABET, IABEE, JABEE, atau lainnya',
            'Melakukan monitoring dan evaluasi pembelajaran',
            'Melakukan rolling out Renstra berdasarkan Indikator Kinerja Utama (IKU) Merdeka Belajar Kampus Merdeka (MBKM) setiap akhir tahun akademik',
          ],
          [
            'PRODI',
            'KK',
            'UPPS',
            'PKA', // ? Bagian Pengembangan Karir dan Konseling
          ]
        ],
        'Program studi dalam rumpun keilmuan yang sama harus mendefinisikan perbedaan kurikulum sesuai dengan panduan kurikulum'
        => [
          [
            'Terdapat dokumen kurikulum dan dokumen monitoring evaluasi.',
            'Persentase mata kuliah yang sama maksimal 40%',
          ],
          [
            'Melakukan evaluasi kurikulum',
          ],
          [
            'PRODI',
            'KK',
            'UPPS',

          ]
        ],
        'Bagian Pelayanan Akademik, UPPS dan Program Studi melakukan perencanaan kelas dengan ketentuan 1 kelas kuota maksimal 40 orang dan 50% dari kuota pada kondisi khusus'
        => [
          [
            'Adanya daftar mahasiswa tiap kelas',
          ],
          [
            'Melakukan perencanaan penyelenggaraan mata kuliah',
            'Melakukan registrasi mata kuliah',
            'Melakukan pengawakan dosen',
          ],
          [
            'PRODI',
            'UPPS',
            'PKA',
            'PAKA',
          ]
        ],
        'UPPS/Program Studi/Kelompok Keahlian melakukan pengawakan dosen sesuai kompetensi dan kualifikasinya yang dituangkan ke dalam Surat Keputusan (SK) Mengajar'
        => [
          [
            'Terdapat tingkat kesesuaian kompetensi dosen dan matakuliah yang dituangkan ke dalam SK mengajar '
          ],
          [
            'Melakukan perencanaan kinerja Dosen',
            'Melakukan survei EDOM',
            'Melakukan evaluasi kesesuaian rencana pengembangan dosen',
            'Melakukan evaluasi kesesuaian dengan ROADMAP penelitian',
            'Melakukan evaluasi kesesuaian dengan sertifikasi keahlian',
          ],
          [
            'UPPS',
            'PRODI',
            'KK',
          ]
        ],
        'UPPS/Program Studi/Bagian Pelayanan Akademik merencanakan penjadwalan dan registrasi mahasiswa yang dilakukan tiap semester'
        => [
          [
            'Adanya jadwal perkuliahan',
            'Adanya  jadwal pelaksanaan KRS mahasiswa tiap awal semester',
          ],
          [
            'Melakukan inventarisasi registrasi mahasiswa',
            'Melakukan evaluasi persiapan perkuliahan mahasiswa',
            'Melakukan evaluasi status akademik',
            'Melakukan sinkronisasi dengan sistem informasi akademik',
          ],
          [
            'UPPS',
            'PRODI',
            'PKA',
            'ITS'
          ]
        ],
        'Rektor bertanggungjawab terhadap peningkatan kapasitas mutu kelembagaan internal maupun eksternal'
        => [
          [
            'Tersedianya dokumen mutu dan SPMI',
            'Tersertifikasi ISO 21001: 2018',
            'Tersertifikasi ISO 9001 : 2015',
            'Tersertifikasi ISO 27000',
            'Peningkatan peringkat dan klaster Kemdikbud',
            'Peningkatan peringkat webometric, WURI, QS AUR, dan Greenmetric',
            'Adanya kontrak kinerja Rektor dengan 8 Indikator Kinerja Utama (IKU) dalam menuju kampus merdeka',
            'UPPS melakukan analisis data/informasi yang merujuk pada pencapaian standar mutu perguruan tinggi yang berkualitas yang didukung oleh keberadaan pangkalan data institusi yang terintegrasi',
            'UPPS memiliki kebijakan dan upaya yang diturunkan ke dalam berbagai peraturan untuk menjamin keberlanjutan program yang mencakup: 4 hal'
          ],
          [
            'Melakukan audit internal setiap tahun',
            'Melakukan audit eksternal setiap tahun (sertifikasi atau surveillance)',
            'Melakukan evaluasi hasil Audit dan tinjauan manajemen',
            'Melakukan evaluasi capaian IKU',
            'Melakukan survei pemahaman visi misi, EDOM, kepuasan karyawan dan mahasiswa terhadap layanan institusi',
            'Melakukan evaluasi renstra setiap tahun',
            'Melakukan evaluasi pencapaian target renstra 2 kali setahun',
            'Melakukan pengukuran manajemen risiko',
            'Mengisi dokumen Laporan Evaluasi Diri (LED) dan Laporan Kinerja Program Studi (LKPS) melalui sistem informasi'
          ],
          [
            'REKTOR',
            'SPMPPP',
            'UPPS',
            'PRODI',
            'SPLSAI'
          ]
        ],
        'UPPS wajib melakukan pengelolaan pembelajaran yang melingkupi: Penyusunan kurikulum dan rencana pembelajaran pada setiap mata kuliah; Mencapai capaian pembelajaran lulusan sesuai dengan standar isi, proses, dan penilaian menurut SNPT; Melakukan kegiatan sistemik sehingga menciptakan suasana akademik dan budaya mutu yang baik; Melakukan kegiatan pemantauan dan evaluasi secara periodik dalam rangka menjaga dan meningkatkan mutu proses pembelajaran; dan Melaporkan hasil program pembelajaran secara periodik'
        => [
          [
            'Terdapat dokumen kurikulum dan rencana pembelajaran pada setiap matakuliah dan mencantumkan capaian pembelajaran lulusan',
            'Terdapat kegiatan himpunan mahasiswa, kuliah umum/studium generale, seminar ilmiah dan bedah buku setiap bulan',
            'Terdapat tindak lanjut minimal 2 kali setiap semester untuk perbaikan proses pembelajaran dan menunjukan peningkatan hasil pembelajaran',
            'Terdapat transparansi hasil pembelajaran secara berkala melalui sistem Igracias',
          ],
          [
            'Melaksanakan kegiatan AMI',
            'Melakukan survei visi misi, EDOM, kepuasan karyawan dan mahasiswa terhadap institusi',
            'Rolling out renstra 1 tahun dalam 1 kali',
            'Evaluasi renstra 2 kali dalam 1 tahun',
            'Melakukan pengukuran manajemen risiko',
            'Mengisi dokumen LED dan LKPS melalui sistem informasi',
            'Melaksanakan program kegiatan diluar pembelajaran terstruktur yang terjadwal untuk meningkatkan suasana akademik',
          ],
          [
            'UPPS',
            'PRODI',
            'SPLSAI',
            'SPMPPP',
          ]
        ],
        'UPPS bertanggung jawab untuk menetapkan dosen pembimbing tugas akhir bagi setiap mahasiswa dan melakukan proses pengendalian penyelesaian tugas akhir mahasiswa.'
        => [
          [
            'Persentase dosen pembimbing tugas akhir mahasiswa yang sesuai dengan bidang keahliannya minimal 75%',
            'Beban dosen sebagai pembimbing utama dan pendamping tugas akhir masing-masing sebanyak 8 mahasiswa.',
            'Adanya SK tentang penugasan dosen pembimbing tugas akhir',
            'Adanya mekanisme plotting dosen tugas akhir Standar Operasional Prosedur (SOP)',
            'Jumlah pertemuan bimbingan tugas akhir minimal 5 dengan dosen pembimbing utama dan 3 dengan dosen pembimbing pendamping',
            'Tingkat kelulusan tugas akhir mahasiswa minimal 50%.',
          ],
          [
            'Proses plotting dosen pembimbing dilakukan dengan menyesuaikan roadmap penelitian dosen',
            'Pengecekan data plotting pada SK penugasan dosen pembimbing tugas akhir',
            'Pengecekan ketersediaan SOP plotting dosen',
            'Pengecekan ketersediaan buku panduan tugas akhir',
            'Pengecekan jumlah bimbingan tugas akhir pada sistem yang tersedia',
            'Konsultasi dengan dosen pengampu mata kuliah tugas akhir.',
          ],
          [
            'PRODI',
            'KK',
            'UPPS',
          ]
        ],

        // B.SPM PPP
        'Bagian Satuan Penjaminan Mutu, Perencanaan dan Pengembangan Pembelajaran melakukan evaluasi serta merumuskan tindak lanjut terhadap proses pembelajaran'
        => [
          [
            'Terdapat perencanaan kegiatan evaluasi pembelajaran yang dilakukan selama 2 kali dalam 1 semester dengan nilai minimal 80%',
            'Kepuasan pembelajaran daring minimal 75%',
            'Kepuasan pelaksanaan tugas akhir minimal 75%',
            'Terdapat laporan tindak lanjut hasil evaluasi EDOM, pembelajaran daring, tugas akhir',
          ],
          [
            'Melakukan survei Evaluasi Dosen Oleh Mahasiswa (EDOM)',
            'Melakukan survei pembelajaran daring',
            'Melakukan survei tugas akhir',
          ],
          [
            'SPMPPP',
          ]
        ],
        'Bagian pelayanan akademik, Program Studi, dan Gugus Jaminan Mutu Program Studi sesuai kewenangan masing – masing melakukan monitoring proses pembelajaran meliputi kecukupan sumberdaya, keterpenuhan waktu pelaksanaan, dan pencapaian hasil pembelajaran selama proses perkuliahan, praktek, dan praktikum yang dilakukan setiap semester'
        => [
          [
            'Okupansi ruang kelas dan praktikum range 60-80%',
            'Pengumpulan soal UTS dan UAS maksimal 14 hari sebelum pelaksanaan',
            'Soal Ujian divalidasi oleh Ketua Program Studi dan Kelompok Keahlian',
            'Rasio DTPS dan mahasiswa program studi 1:30',
            'Maksimal rasio dosen luar biasa 10% dari jumlah DTPS',
            'Realisasi pelaksanaan perkuliahan minimal 85% (minimal 14 pertemuan termasuk UTS dan UAS)',

            //P Akademik
            'Kesesuaian materi kuliah dengan RPS sebesar 100%',

            'Beban kinerja dosen 12-16 SKS',
            'Pengumpulan nilai maksimal 10 hari setelah pelaksanaan ujian',
            'Kepuasan EDOM minimal 80%',
          ],
          [
            'Melaksanakan : Audit AMI; Monitoring dan evaluasi kinerja Dosen; survei EDOM; dan Rapat evaluasi akhir semester',
          ],
          [
            'PAKA',
            'PRODI',
            'GJMPROD',
            'SPLSAI',
            'SPMPPP',
          ]
        ],
        'Koordinator mata kuliah dan dosen mata kuliah harus membuat laporan perkuliahan dalam bentuk portofolio mata kuliah yang terintegrasi di sistem informasi akademik setiap semester'
        => [
          [
            'Terdapat portofolio perkuliahan yang mencakup informasi tentang: Nama dan kode mata kuliah; Materi perkuliahan; Interaksi pembelajaran; Evaluasi pembelajaran; dan Jumlah mahasiswa yang hadir',
          ],
          [
            'Melakukan monitoring dan evaluasi perkuliahan yang disahkan oleh koordinator mata kuliah, dosen pengampu, dan  ketua program studi',
            'Melaksanakan Audit Mutu Internal (AMI)',
          ],
          [
            'PRODI',
            'ITS',
            'SPMPPP',
          ]
        ],

        //P Akademik
        'Bagian pelayanan akademik harus menyusun kalender akademik beserta panduan operasional yang memuat semua aktivitas pembelajaran dari awal sampai akhir sebelum tahun akademik baru dimulai setiap tahun'
        => [
          [
            'Terdapat kalender akademik setiap tahun',
          ],
          [
            'Melakukan pengumpulan data kegiatan dari setiap unit',
            'Melakukan evaluasi kegiatan akademik dalam waktu 1 tahun',
          ],
          [
            'PAKA',
          ]
        ],
        'Urusan Perpustakaan harus memfasilitasi mahasiswa dan dosen untuk menyediakan buku dan langganan jurnal guna mendukung pembelajaran dan penelitian mahasiswa dan Dosen'
        => [
          [
            'Tersedianya referensi buku dan langganan jurnal dari perpustakaan sebagai berikut: Buku teks minimal 200 buku per program studi; Langganan jurnal atau majalah ilmiah minimal 1 yang sesuai untuk setiap program studi dalam waktu 3 tahun terakhir; dan Langganan ejournal minimal 1 yang sesuai untuk setiap program studi dalam waktu 3 tahun terakhir',
            'Tersedianya prosiding seminar internasional dalam waktu 3 tahun terakhir',
          ],
          [
            'Melakukan stock opname minimal setiap tahun',
            'Melakukan AMI',
          ],
          [
            'PAKA',
          ]
        ],
      ], //5
      'Standar Penilaian Pembelajaran'
      => [
        'Seluruh dosen menerapkan mekanisme penilaian yang terdiri atas menyusun, melaksanakan, memberikan umpan balik dan mendokumentasikan penilaian secara transparan dengan beberapa ketentuan: 2 hal'
        => [
          [
            'Terdapat dokumen kontrak rencana pembelajaran',
            'Terdapat pelaksanaan kuis, tugas besar, UTS dan UAS',
            'Adanya kontrak pembelajaran di awal kuliah.',
            'Terdapat nilai mahasiswa yang diunggah melalui sistem informasi akademik',
          ],
          [
            'Setiap RPS memuat pertemuan yang membahas kontrak pembelajaran pada pertemuan pertama.',
            'Setiap mahasiswa wajib mengikuti evaluasi (ujian) yang diselenggarakan oleh dosen maupun akademik',
          ],
          [
            'UPPS',
            'PRODI',
            'UAKA'
          ]
        ],
        'Seluruh dosen harus melakukan proses penilaian yang mencakup prinsip edukatif, otentik, objektif, akuntabel, dan transparan, yang dilakukan secara terintegrasi agar sistem penilaian yang digunakan dapat dipahami dan digunakan oleh semua pemangku kepentingan'
        => [
          [
            'Adanya Buku Panduan Akademik (BPA) yang memuat rubrik penilaian',
            'Adanya kontrak belajar di awal perkuliahan yang memuat sistem penilaian',
            'Terdapat nilai mahasiswa yang diunggah melalui sistem informasi akademik maupun laporan nilai yang disahkan oleh ketua program studi'
          ],
          [
            'Melaksanakan evaluasi dosen oleh mahasiswa (EDOM) di akhir semester',
            'Melakukan evaluasi dari dokumen pelaporan penilaian setiap semester',
          ],
          [
            'DOSEN',
            'PRODI',
            'UPPS',
            'UAKA',
          ]
        ],
        'Seluruh dosen melaksanakan pelaporan penilaian sesuai dengan rencana pembelajaran semester berupa kualifikasi keberhasilan mahasiswa dalam menempuh suatu mata kuliah agar dapat dihitung IPS dan IPK mahasiswa'
        => [
          [
            'Terdapat aturan range penilaian mahasiswa (A, AB, dst)',
            'Terdapat aturan penilaian mahasiswa per semester (IPS) dan kumulatif (IPK)',
            'Terdapat dokumen laporan penilaian dari dosen tiap Mata kuliah dan KHS mahasiswa',
          ],
          [
            'Melakukan pelaporan penilaian setiap semester',
          ],
          [
            'DOSEN',
            'PRODI',
            'UPPS',
            'UAKA',
          ]
        ],
        'Wakil Rektor I bidang Akademik dan Riset menetapkan aturan kelulusan mahasiswa dengan Indeks Prestasi Kumulatif (IPK) lebih besar atau sama dengan 2,00 (dua koma nol nol) dan mahasiswa wajib memiliki sertifikat kompetensi yang diterbitkan oleh Perguruan Tinggi bekerjasama dengan organisasi profesi, lembaga pelatihan atau lembaga sertifikasi yang terakreditasi pada setiap kelulusan'
        => [
          [
            'Terdapat dokumen standar  akademik yang mengatur kelulusan mahasiswa',
            'Terdapat dokumen yang mengatur pemberian predikat kelulusan dan penetapan predikat kelulusan berdasarkan pemeringkatan IPK mahasiswa sesuai aturan oleh Rektor',
            'Terdapat MoU dengan organisasi profesi, lembaga pelatihan atau lembaga sertifikasi yang terakreditasi',
            'Terdapat pedoman penerbitan ijazah',
          ],
          [
            'Melakukan Audit Mutu Internal (AMI)',
            'Melakukan evaluasi implementasi kerjasama sertifikasi',
          ],
          [
            'WAREKI',
            'UPPS',
            'PRODI',
            'PAKA',
            'PKA' //? Bagian Pengembangan Karir dan Alumni
          ]
        ],
        'Seluruh Dosen bertanggungjawab terhadap pelaksanaan penilaian pembelajaran (proses dan hasil belajar mahasiswa) untuk mengukur ketercapaian capaian pembelajaran yang mencakup: Edukatif; Otentik; Objektif; Akuntable; dan Transparan yang dilakukan secara terintegrasi dengan penilaian minimum 70% jumlah mata kuliah'
        => [
          [
            'Terdapat pedoman rubrik, portofolio dan penilaian pembelajaran',
            'Adanya Buku Panduan Akademik (BPA) yang memuat rubrik penilaian',
            'Adanya kontrak belajar di awal perkuliahan yang memuat sistem penilaian',
          ],
          [
            'Melakukan survei Evaluasi Dosen Oleh Mahasiswa (EDOM) terkait penilaian pembelajaran',
          ],
          [
            'UPPS',
            'PRODI',
            'PAKA',
            'DOSEN',
            'SPMPPP',
          ]
        ],
        'Program Studi menetapkan kinerja mata kuliah dengan persentase ketidaklulusan maksimal 10% ( nilai D dan E)'
        => [
          [
            'Terdapat berita acara penilaian matakuliah dari Dosen ke Program Studi',
          ],
          [
            'Melakukan evaluasi pembelajaran semua matakuliah setiap akhir semester',
          ],
          [
            'UPPS',
            'PRODI',
            'WAREKI',
          ]
        ],
      ], //6
      'Standar Proses Pembelajaran'
      => [
        'UPPS bersama Bagian Logistik dan Manajemen Aset bertanggung jawab memastikan ketersediaan dan kesiapan sarana dan prasarana kegiatan perkuliahan dan praktikum'
        => [
          [
            'Tersedianya informasi sarana dan prasarana',
            'Ketersediaan dokumen hasil pemeriksaan sarana dan prasarana perkuliahan',
          ],
          [
            'Melakukan pengawasan sarana dan prasarana perkuliahan',
            'Melakukan pengecekan ketersediaan dokumen hasil pemeriksaan sarana dan prasarana',
          ],
          [
            'UPPS',
            'LMA',
          ]
        ],
        'UPPS bertanggung jawab untuk melakukan rekrutmen asisten lab/asisten praktikum paling lambat 2 pekan sebelum perkuliahan berlangsung.'
        => [
          [
            'Adanya bukti kegiatan rekruitasi asisten praktikum yang dilaksanakan paling lambat 2 pekan sebelum perkuliahan berlangsung',
            'Semua asisten memiliki kompetensi yang sesuai dengan  mata kuliah praktikum yang diampu'
          ],
          [
            'Melakukan validasi bukti kegiatan rekruitasi asisten praktikum',
            'Pengecekan nilai mata kuliah yang berhubungan dengan mata kuliah praktikum akan diampu oleh asisten praktikum'
          ],
          [
            'UPPS',
            'PRODI',
          ]
        ],
        'UPPS menyusun pedoman pelaksanaan Kerja Praktik/Magang Mahasiswa'
        => [
          [
            'Terdapat dokumen pedoman kerja praktik/ magang di setiap fakultas.',
            'Terdapat pengawakan Dosen Pembimbing PKL',
            'Terdapat dokumen evaluasi magang per tahun',
            'Terdapat laporan Magang yang di presentasikan oleh mahasiswa kepada dosen pembimbing.',
            'Terdapat penilaian magang yang dilakukan oleh dosen  pembimbing  dan pembimbing lapangan ( dari lembaga tempat magang)'
          ],
          [
            'Melakukan evaluasi pedoman pelaksanaan Kerja Praktik/Magang',
            'Melakukan evaluasi pelaksanaan Kerja Praktik/Magang melibatkan lembaga yang menjadi lokasi magang mahasiswa.'
          ],
          [
            'UPPS'
          ]
        ],
        'UPPS, Program Studi, dan Kelompok Keahlian memastikan kesesuaian antara kompetensi dan kualifikasi dosen dengan mata kuliah yang diampu.'
        => [
          [
            'Adanya dokumen peta kompetensi dosen sesuai bidang keahlian masing - masing',
            'Adanya rekaman mutu pengawakan dosen  matakuliah',
            'Adanya SK tentang penugasan mengajar dosen'
          ],
          [
            'Melakukan pengawakan dosen pengampu mata kuliah sesuai peta kompetensi dosen',
            'Melakukan monitoring dan evaluasi pelaksanaan Standar Operasional Prosedur (SOP) pengawakan dosen pengampu matakuliah',
          ],
          [
            'UPPS',
            'PRODI',
            'KK',
          ]
        ],
        'UPPS melaksanakan Monitoring dan evaluasi pelaksanaan proses pembelajaran mencakup karakteristik, perencanaan, pelaksanaan, proses pembelajaran dan beban belajar mahasiswa untuk memperoleh capaian pembelajaran lulusan.'
        => [
          [
            'Terdapat dokumen RPS',
            'Terdapat BAP perkuliahan',
            'Terdapat dokumen kurikulum yang memuat CPL'
          ],
          [
            'Melakukan evaluasi perkuliahan',
            'Melakukan AMI',
          ],
          [
            'UPPS',
            'SPLSAI'
          ]
        ],
        'Bagian pelayanan akademik bertanggung jawab atas ketersediaan panduan akademik mengenai beban belajar mahasiswa yang memuat masa belajar, jumlah sks minimal yang harus ditempuh, distribusi mata kuliah'
        => [
          [
            'Terdapat dokumen panduan akademik',
          ],
          [
            'Melakukan evaluasi pada BPI setiap tahun',
          ],
          [
            'UPPS',
            'PRODI',
            'PAKA',
          ]
        ],

        // P Akademik
        'Program Studi melakukan evaluasi masa studi mahasiswa pada setiap akhir tahun akademik'
        => [
          [
            'Terdapat laporan studi mahasiswa setiap akhir tahun akademik',
          ],
          [
            'Melakukan evaluasi tingkat di setiap akhir tahun akademik',
          ],
          [
            'PRODI',
            'PAKA',
            //'Dosen pembimbing akademik',
          ]
        ],

        // Gugus Jaminan Mutu
        'Program Studi bertanggung jawab memastikan kesesuaian proses pembelajaran Dosen pengampu terhadap rencana pembelajaran (RPS dan Kontrak Perkuliahan)'
        => [
          [
            'Terdapat dokumen rencana pembelajaran (RPS dan Kontrak Perkuliahan)',
          ],
          [
            'Melakukan Pemeriksaan dokumen rencana pembelajaran (RPS dan Kontrak Perkuliahan)',
          ],
          [
            'PRODI',
            'GJMPROD',
            'KK',
          ]
        ],
      ], //7
      'Standar Sarana dan Prasarana Pembelajaran'
      => [
        'Kepala Bagian Logistik dan Manajemen Aset menyediakan sarana pembelajaran terdiri atas perabot ; peralatan pendidikan ; media pendidikan ; buku , buku elektronik , dan repositori ; sarana teknologi informasi dan komunikasi; instrumentasi eksperimen ; sarana olahraga ; sarana berkesenian ; sarana fasilitas umum ; bahan habis pakai; dan sarana pemeliharaan, keselamatan, dan keamanan yang memadai, bermutu baik dan mudah diakses.'
        => [
          [
            'Tersedia dan tercukupi fasilitas yang dapat digunakan secara aman dan nyaman',
            'Terdapat Peralatan Pembelajaran : Papan Tulis, Alat Tulis, Proyektor, Layar mencukupi secara jumlah dan bisa digunakan secara optimal dan nyaman',
            'Tersedia buku dan buku elektronik (e-book) yang mencukupi secara jumlah, ragam dan relevan serta mudah diakses',
            'Repositori mencukupi secara jumlah, beragam dan relevan dan mudah diakses.',
            'Ketersediaan sarana Teknologi Informasi dan Komunikasi (TIK) yang mencukupi secara jumlah dan handal dalam penggunaannya',
            'Ketersediaan Sistem Informasi untuk mengumpulkan data yang lengkap dan akurat, dapat dipertanggungjawabkan dan terjaga kerahasiaannya.',
            'Ketersediaan Sistem Informasi untuk mengelola dan menyebarkan ilmu pengetahuan',
            'Ketersediaan instrumentasi eksperimen yang mencukupi secara jumlah dan dapat digunakan secara optimal',
            'Bahan habis pakai dalam kegiatan praktek tersedia dalam jumlah yang mencukupi dan sesuai kebutuhan',
            'Ketersediaan peralatan olahraga yang mencukupi secara kuantitas dan dapat digunakan secara optimal',
            'Ketersediaan peralatan berkesenian yang mencukupi secara kuantitas dan dapat digunakan secara optimal',
            'Ketersediaan sarana ibadah yang memadai bagi seluruh pemeluk agama dalam jumlah mencukupi dan nyaman digunakan',
            'Ketersediaan kantin yang sehat, bersih dan mudah diakses civitas akademik',
            'Ketersedian peralatan Keselamatan dan Keamanan Kerja dalam jumlah yang cukup, mudah diakses dan handal',
          ],
          [
            'Melakukan pendataan dan pencatatan sarana pembelajaran',
            'Melakukan asesmen dan pemeliharaan sarana  pembelajaran',
            'Melakukan survei kepuasaan pengguna sarana pembelajaran',
          ],
          [
            'UPPS',
            'LMA',
            'PAKA',
            'ITS',
            'UPP',
          ]
        ],
        'UPPS memastikan pengelolaan laboratorium dan perpustakan sesuai dengan standar akreditasi (tersertifikasi)'
        => [
          [
            'Terdapat pedoman pengelolaan laboratorium dan perpustakaan',
          ],
          [
            'Melakukan akreditasi atau sertifikasi Komite Akreditasi Nasional (KAN)',
          ],
          [
            'UPPS',
          ]
        ],

        // IT Support
        'Kepala Bagian IT Support menyediakan sarana melalui penguatan IT dalam bidang pengembangan sistem informasi terintegrasi dan pengembangan infrastruktur jaringan'
        => [
          [
            'Tersedianya koneksi internet yang dapat diakses oleh seluruh sivitas akademika',
          ],
          [
            'Melakukan survei kepuasan pengguna.',
            'Melakukan pelaporan penggunaan bandwidth institusi terbaru.',
          ],
          [
            'ITS',
          ]
        ],
        'Kepala Bagian IT Support memastikan pengelolaan keamanan informasi sesuai dengan standar ISO 27001'
        => [
          [
            'Terdapat dokumen Standar Manajemen Keamanan Informasi (SMKI)',
            'Tersedianya dokumen manajemen risiko keamanan informasi',
          ],
          [
            'Melakukan audit ISO 27001.',
          ],
          [
            'ITS',
          ]
        ],

        //P Akademik
        'Kepala Bagian Logistik dan Manajemen Aset menyediakan  prasarana pembelajaran terdiri atas terdiri atas lahan ; ruang kelas ; perpustakaan; laboratorium /studio/ bengkel /unit produksi ; tempat berolahraga ; ruang untuk berkesenian ; ruang unit kegiatan mahasiswa; ruang pimpinan perguruan tinggi; ruang dosen ; ruang tata usaha; dan fasilitas umum yang memadai, bermutu baik dan mudah diakses.'
        => [
          [
            'Ketersediaan Lahan dengan luas minimal 10.000 Meter Persegi di lokasi yang nyaman dan sehat',
            'Ketersediaan ruang kelas luas paling sedikit 1 meter persegi per mahasiswa dalam jumlah yang mencukupi, nyaman digunakan dan mudah diakses',
            'Ketersediaan Perpustakaan dengan luasan paling sedikit 200 meter persegi yang memadai, nyaman untuk digunakan dan mudah diakses',
            'Ketersediaan Laboratorium/Studio/Bengkel/Unit Produksi dalam jumlah yang cukup, nyaman untuk digunakan dan mudah diakses',
            'Ketersediaan gedung dan ruang olahraga yang mencukupi, nyaman untuk digunakan dan mudah diakses',
            'Ketersedian ruang student center dalam jumlah cukup, nyaman untuk digunakan dan mudah diakses',
            'Ketersedian ruang Pimpinan PT dalam jumlah cukup, nyaman untuk digunakan dan mudah diakses',
            'Ketersedian ruang Dosen (ukuran 2 X 2 Meter) dalam jumlah cukup, nyaman untuk digunakan dan mudah diakses',
            'Ketersedian ruang administrasi umum/ tata usaha paling sedikit 4 meter persegi per TPA dalam jumlah cukup, nyaman digunakan dan mudah diakses',
            'Ketersediaan ruang ibadah untuk berbagai pemeluk agama dalam jumlah yang cukup, nyaman dan mudah diakses',
            'Ketersediaan ruang kantin yang cukup secara jumlah, nyaman dan mudah diakses',
            'Ketersediaan area parkir dengan luasan yang cukup, nyaman dan mudah diakses',
            'Ketersediaan toilet yang cukup secara jumlah, nyaman dan mudah diakses pada setiap gedung',
            'Ketersediaan air bersih dalam jumlah yang mencukupi, tidak bau dan tidak berwarna.',
            'Kepuasan Pengguna minimal 80%',
          ],
          [
            'Melakukan kegiatan asesmen secara rutin dan menyeluruh terhadap kondisi prasarana pembelajaran yang ada',
            'Melakukan survei Kepuasan Pengguna  prasarana pembelajaran.',
          ],
          [
            'LMA',
            'PAKA',
            'MHSN',
          ]
        ],

        //P Logistik Aset
        'Kepala Bagian Logistik dan Manajemen Aset menyediakan sarana dan  prasarana yang dapat diakses oleh mahasiswa yang  berkebutuhan khusus.'
        => [
          [
            'Ketersediaan informasi yang dapat diakses oleh pengguna berkebutuhan khusus',
            'Ketersediaan lerengan (ramp) untuk pengguna kursi roda',
            'Ketersediaan jalur pemandu (guiding block) di jalan atau koridor  di lingkungan kampus',
            'Ketersediaan peta/denah kampus atau gedung dalam bentuk  peta/denah timbul',
            'Ketersediaan toilet atau kamar mandi untuk pengguna kursi roda',
          ],
          [
            'Melakukan pendataan dan pencatatan sarana dan prasarana pembelajaran pengguna berkebutuhan khusus',
            'Melakukan asesmen dan pemeliharaan sarana  dan prasarana pembelajaran pengguna berkebutuhan khusus',
            'Melakukan survei kepuasaan pengguna sarana dan prasarana pembelajaran berkebutuhan khusus',
          ],
          [
            'LMA',
          ]
        ],
      ], //8
    ];

    $standarKriteriaPenelitian = [
      'Standar Hasil Penelitian'
      => [
        'LPPM wajib memfasilitasi publikasi hasil penelitian dosen dan mahasiswa dalam bentuk artikel ilmiah, kekayaan intelektual, karya seni ataupun buku ber-ISBN dalam rangka mengembangkan ilmu pengetahuan dan teknologi, serta meningkatkan kesejahteraan masyarakat dan daya saing bangsa.'
        => [
          [
            'Terdapat laporan jumlah artikel ilmiah yang telah dipresentasikan dalam konferensi ilmiah sesuai dengan target Kontrak Manajemen (KM)',
            'Terdapat laporan jumlah artikel ilmiah pada jurnal nasional terakreditasi yang telah terbit sesuai dengan target KM',
            'Terdapat laporan jumlah artikel ilmiah pada jurnal internasional bereputasi yang telah terbit sesuai dengan target KM',
            'Terdapat laporan jumlah hasil penelitian yang terdaftar sebagai Paten sesuai dengan target KM',
            'Terdapat laporan jumlah hasil penelitian yang telah terdaftar hak kekayaan intelektualnya seperti Merek, Hak Cipta, Desain Industri, Indikasi Geografis, Rahasia Dagang, Desain Tata Letak Sirkuit Terpadu sesuai target KM',
            'Terdapat laporan jumlah buku ber-ISBN yang telah diterbitkan oleh Penerbit Nasional sesuai target KM',
          ],
          [
            'Merekap kegiatan konferensi ilmiah yang dilaksanakan oleh dosen, baik nasional maupun internasional setiap tahun',
            'Merekap jumlah artikel ilmiah yang diterbitkan pada Jurnal Sinta 3, Sinta 2 dan Sinta 1 setiap tahun',
            'Merekap jumlah penelitian yang telah terdaftar Paten produknya setiap tahun',
            'Merekap jumlah penelitian yang telah terdaftar Kekayaan Intelektualnya selain Paten setiap tahun.',
            'Melakukan rekap jumlah hasil penelitian dalam bentuk buku ber-ISBN yg telah diterbitkan oleh penerbit Nasional setiap tahun',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
            'MHS',
          ]
        ],
      ], //9
      'Standar Isi Penelitian'
      => [
        'Dosen dan mahasiswa wajib menyesuaikan topik penelitian dengan Rencana Induk Penelitian (RIP) institut'
        => [
          [
            'Terdapat laporan kesesuaian antara arah penelitian dengan Rencana Induk Penelitian (RIP) sesuai dengan target Rencana Strategis Institut',
          ],
          [
            'Melakukan pemeriksaan kesesuaian antara laporan arah penelitian dosen dengan Rencana Induk Penelitian (RIP) dosen maupun RIP institut',
          ],
          [
            'DOSEN',
            'MHS',
            'LPPM',
            'KK',
          ]
        ],

        // Sentra Inovasi
        'LPPM menetapkan skema penelitian dasar yang berorientasi pada luaran penelitian yang berupa penjelasan atau penemuan untuk mengantisipasi suatu gejala, fenomena, kaidah, model, atau postulat baru pada Tingkat Kesiapan Teknologi (TKT) 1 - 3'
        => [
          [
            'Terdapat laporan jumlah kegiatan penelitian dasar sebesar 40% dari total penelitian',
            'Terdapat laporan kesesuaian antara usulan penelitian dasar dengan isi luaran penelitian dasar',
          ],
          [
            'Melakukan rekap dan mengelompokkan judul-judul penelitian yang terselenggara setiap tahun',
          ],
          [
            'LPPM',
          ]
        ],
        'LPPM menetapkan skema penelitian terapan yang berorientasi pada luaran penelitian yang berupa inovasi serta pengembangan ilmu pengetahuan dan teknologi yang bermanfaat bagi masyarakat, dunia usaha, dan/ atau industri pada Tingkat Kesiapan Teknologi (TKT) 4-6'
        => [
          [
            'Terdapat laporan jumlah kegiatan penelitian terapan sebesar 30% dari total penelitian',
            'Terdapat laporan kesesuaian luaran penelitian dengan isi materi penelitian terapan',
          ],
          [
            'Membandingkan antara luaran penelitian dengan kriteria penelitian terapan setiap tahun',
          ],
          [
            'LPPM',
          ]
        ],
        'Inovasi menetapkan skema untuk mencapai pengembangan lebih lanjut pada tahapan model/ produk/ purwarupa dalam proses pengukuran TKT. Hasil penelitian pengembangan berada di level TKT 7 sampai 9'
        => [
          [
            'Terdapat laporan jumlah kegiatan riset pengembangan sebesar 30% dari total penelitian',
            'Terdapat laporan kesesuaian luaran penelitian dengan isi materi penelitian pengembangan',
          ],
          [
            'Membandingkan antara luaran penelitian dengan kriteria penelitian pengembangan setiap tahun',
          ],
          [
            'LPPM',
            'SINO',
          ]
        ],
      ], //10
      'Standar Proses Penelitian'
      => [
        'Dosen dan mahasiswa harus memperhatikan proses penjaminan mutu pada perencanaan, pelaksanaan dan pelaporan penelitian'
        => [
          [
            'Terdapat dokumen proposal penelitian yang diajukan oleh dosen dan mahasiswa',
            'Terdapat laporan kemajuan atau bimbingan penelitian untuk mahasiswa',
            'Terdapat laporan akhir penelitian atau laporan tugas akhir / skripsi bagi penelitian mahasiswa',
          ],
          [
            'Melakukan pengecekan ajuan proposal, laporan kemajuan, dan laporan akhir penelitian di sistem informasi penelitian',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
            'MHS',
          ],
        ],
        'Dosen dan mahasiswa yang melaksanakan penelitian wajib mematuhi standar mutu penelitian serta mempertimbangkan standar keamanan dan keselamatan kerja'
        => [
          [
            'Terdapat petunjuk dan peralatan K3 untuk penelitian di laboratorium atau tempat penelitian',
          ],
          [
            'Melakukan ceklist penggunaan peralatan K3 sesuai petunjuk penggunaan',
          ],
          [
            'DOSEN',
            'MHS',
            'LPPM',
            'KAURLAB',
            'KK',
          ],
        ],
        'Dosen dan mahasiswa dalam pelaksanaan penelitian wajib mempertimbangkan analisis dampak lingkungan (amdal) pada tempat penelitian'
        => [
          [
            'Terdapat dokumen amdal',
          ],
          [
            'Melakukan ceklist dan analisis terhadap dampak lingkungan yang terjadi',
          ],
          [
            'DOSEN',
            'MHS',
            'LPPM',
            'KAURLAB',
            'KK',
          ],
        ],


        'Mahasiswa yang melakukan penelitian dalam rangka skripsi atau tugas akhir harus memilih topik yang relevan dengan capaian pembelajaran lulusan dan memenuhi beban kredit 6 sks untuk program sarjana dan 4 sks untuk program diploma serta menghasilkan karya ilmiah yang layak dipublikasi'
        => [
          [
            'Adanya karya ilmiah yang dipublikasikan di jurnal atau conference',
            'Terdapat KHS yang memenuhi 6 sks penelitian untuk program sarjana dan 4 sks penelitian untuk program diploma',
          ],
          [
            'Menghitung jumlah karya ilmiah yang dipublikasikan oleh mahasiswa',
            'Melakukan pemeriksaan atau pengecekan KHS sebagai syarat yudisium',
          ],
          [
            'LPPM',
            'MHS',
            'AKAFAK',
            'KK',
          ],
        ],
        'Riset mahasiswa dalam melakukan penelitian skripsi atau tugas akhir harus beorientasi pencapaian IKU-5 dalam konsep kampus merdeka (MBKM) yang berbasis rekognisi untuk ITTelkom'
        => [
          [
            'Adanya karya ilmiah yang dipublikasikan dan join riset dengan industri',

            //Industri
            'Adanya join riset dengan industri',
          ],
          [
            'Menghitung jumlah MOU',
          ],
          [
            'LPPM',
            'MHS',
            'INDUSTRI',
            'KK',
          ],
        ],
      ], //11
      'Standar Penilaian Penelitian'
      => [
        'LPPM harus menerapkan penilaian menggunakan metode dan instrumen yang relevan, akuntabel, dan dapat mewakili ukuran ketercapaian kinerja proses serta pencapaian kinerja hasil penelitian.'
        => [
          [
            'Adanya tim reviewer internal penelitian',
            'Adanya penilaian yang dilakukan secara presentasi lisan oleh peneliti',
          ],
          [
            'Membuat surat keputusan rektor terkait tim reviewer internal penelitian',
            'Melakukan penilaian terhadap presentasi peneliti',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
          ],
        ],
        'LPPM wajib menetapkan Tim Reviewer internal setiap setahun sekali minimal dosen yang memiliki jabatan Lektor'
        => [
          [
            'Terdapat dokumen penetapan yang memuat minimal Tim reviewer wajib memiliki jabatan Lektor',
          ],
          [
            'Melakukan monitoring dan evaluasi JFA dosen yang memiliki jabatan Lektor untuk diajukan sebagai Reviewer penelitian.',
          ],
          [
            'LPPM',
            'DOSEN',
          ],
        ],


        'LPPM wajib menetapkan rubrik penilaian hibah penelitian internal yang dipergunakan oleh reviewer untuk memberikan penilaian secara obyektif.'
        => [
          [
            'Terdapat rubrik penilaian yang direview setiap tahun oleh LPPM',
          ],
          [
            'Melakukan review rubrik penilaian setiap tahun untuk disesuaikan dengan regulasi terkini',
          ],
          [
            'LPPM',
            'TRVIEW',
          ],
        ],

        // IT Support
        'LPPM harus melaksanakan penilaian proses dan hasil penelitian secara terintegrasi dengan prinsip penilaian edukatif, objektif, akuntabel, dan transparan.'
        => [
          [
            'Adanya kriteria dan prosedur penilaian untuk proses perencanaan, pelaksanaan maupun pelaporan penelitian',
            'Adanya Sistem informasi penelitian untuk menunjang proses penilaian penelitian',
          ],
          [
            'Melakukan rekap atau mereview terhadap kriteria dan prosedur penilaian penelitian',
            'Melakukan monitoring pemenuhan kriteria maupun prosedur penilaian pada sistem informasi penilaian penelitian',
          ],
          [
            'LPPM',
            'ITS',
          ],
        ],
      ], //12
      'Standar Peneliti'
      => [
        'Peneliti wajib berpendidikan minimal Strata 2 (S2) atau magister dan pernah mempublikasikan hasil penelitiannya di jurnal ilmiah, memiliki kemampuan tingkat penguasaan metodologi penelitian yang sesuai dengan bidang keilmuan, objek penelitian, serta tingkat kerumitan dan tingkat kedalaman penelitian dan memiliki Rencana Induk Penelitian (RIP) Dosen'
        => [
          [
            'Adanya ijazah S2 dan publikasi paper di jurnal ilmiah dan memiliki RIP Dosen',
          ],
          [
            'Melakukan pengecekan publikasi di google scholar atas nama peneliti',
            'Melakukan pengecekan di data SDM',
            'Melakukan pemeriksaan dokumen RIP dosen',
          ],
          [
            'LPPM',
            'SDM',
            'DOSEN',
            'KK',
          ],
        ],
        'Peneliti yang pernah mendaftarkan paten dari hasil penelitiannya berwenang menjadi ketua pada skema penelitian dasar, terapan dan pengembangan'
        => [
          [
            'Terdapat dokumen pendaftaran paten atas nama peneliti',
            'Terdapat dokumen sertifikat HKI atas nama peneliti',
          ],
          [
            'Mengecek di website direktorat jenderal kekayaan intelektual dan sertifikat',
          ],
          [
            'LPPM',
            'DOSEN',
            'KK',
            'MITRA',
          ],
        ],
        'Peneliti yang pernah mempublikasikan hasil penelitiannya di jurnal akreditasi berwenang menjadi ketua pada skema penelitian dasar'
        => [
          [
            'Terdapat dokumen publikasi ilmiah di jurnal terakreditasi atas nama peneliti',
          ],
          [
            'Melakukan pengecekan di google scholar, scopus, Sinta atau pengindeks lainnya',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
          ],
        ],
      ], //13
      'Standar Sarana dan Prasarana Penelitian'
      => [
        'Rektor harus menyediakan buku-buku pembelajaran, referensi, jurnal dan majalah ilmiah serta akses ke sumber-sumber referensi digital terbaru.'
        => [
          [
            'Ketersediaan buku pembelajaran setiap program studi minimal 250 judul, referensi, jurnal dan majalah ilmiah pada perpustakaan'
          ],
          [
            'Melakukan rekap kebutuhan buku pembelajaran, referensi dan jurnal setiap prodi'
          ],
          [
            'LPPM',
            'URPERPUS',
          ],
        ],
        'Rektor harus menyediakan dan mengoptimalkan penggunaan software pengecekan plagiat'
        => [
          [
            'Adanya software pengecekan plagiat sesuai dengan rekomendasi kementerian pendidikan dan kebudayaan riset dan teknologi'
          ],
          [
            'Mendata pengguna software pengecekan plagiat'
          ],
          [
            'LPPM',
            'URPERPUS',
          ],
        ],
        'Rektor harus menyediakan laboratorium khusus riset yang sesuai kebutuhan penelitian'
        => [
          [
            'Adanya laboratorium khusus riset di masing-masing fakultas'
          ],
          [
            'Melakukan pendataan aktivitas penelitian pada laboratorium riset'
          ],
          [
            'KK',
            'KAURLAB',
            'LPPM',
          ],
        ],

        // IT Support
        'Rektor harus menyediakan akses layanan internet yang stabil dan berkecepatan tinggi kepada para peneliti'
        => [
          [
            'Kecepatan akses internet up to 1 MBps per orang'
          ],
          [
            'Melakukan pengukuran kecepatan akses internet secara berkala'
          ],
          [
            'ITS',
          ],
        ],

        // Kaur Lab
        'Rektor harus menjamin bahwa setiap laboratorium penelitian dilengkapi dengan alat pemadam kebakaran, P3K, K3 dan sarana penanganan limbah B3'
        => [
          [
            'Ketersediaan alat pemadam kebakaran, P3K, K3 dan sarana penanganan limbah B3 di setiap laboratorium yang berfungsi dengan baik',
          ],
          [
            'Melakukan rekap, memastikan keberadaan dan fungsinya,  serta melakukan pendataan  perlengkapan pemadam kebakaran, P3K, K3 dan penanganan limbah B3 di setiap laboratorium sebulan sekali'
          ],
          [
            //'Logistik', ?LMA
            'KAURLAB',
          ],
        ],
      ], //14
      'Standar Pengelolaan Penelitian'
      => [
        'LPPM wajib melaksanakan penelitian dengan melakukan seleksi proposal penelitian dan pemantauan terhadap kemajuan penelitian pada tahun berjalan'
        => [
          [
            'Terdapat laporan seleksi proposal penelitian',
            'Terdapat Log book penelitian',
            'Terdapat laporan Monitoring dan evaluasi (Monev) kemajuan penelitian',
          ],
          [
            'Melakukan penilaian atau review terhadap proposal penelitian yang diajukan dosen',
            'Melakukan pengecekan terhadap logbook setiap peneliti',
            'Melakukan monev yang dilaksanakan di pertengahan periode tahun penelitian',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
          ],
        ],
        'LPPM wajib melakukan monitoring dan evaluasi terhadap kegiatan penelitian yang sesuai antara Rencana Induk Penelitian (RIP) dosen dan RIP institut setiap tahun'
        => [
          [
            'Terdapat dokumen laporan penelitian',
          ],
          [
            'Melakukan evaluasi terhadap progres akhir penelitian',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
          ],
        ],
        'LPPM harus memberikan insentif terhadap prestasi dosen dalam bidang penelitian setiap tahunnya sesuai dengan aturan yang ditetapkan dalam SK Insentif'
        => [
          [
            'Terdapat Surat Keputusan (SK) Insentif',
            'Terdapat laporan jumlah dosen penerima insentif penelitian',
          ],
          [
            'Melakukan rekap jumlah penerima insentif penelitian dalam satu tahun',
            'Melakukan audit',
          ],
          [
            'LPPM',
            'IA',
            'DOSEN',
          ],
        ],
        'LPPM wajib melakukan pelaporan kinerja penelitian melalui pangkalan data pendidikan tinggi'
        => [
          [
            'Terdapat laporan atau rekap data penelitian yang diinputkan di pangkalan data pendidikan tinggi',
          ],
          [
            'Melakukan input data ke pangkalan data perguruan tinggi dengan dibuktikan dengan bukti submit',
            'Melakukan audit',
          ],
          [
            'LPPM',
            'IA',
            'DOSEN',
          ],
        ],

        // Sentra Inovasi
        'LPPM bersama unit terkait wajib memfasilitasi kegiatan pengembangan kompetensi dosen dalam penelitian, penulisan artikel ilmiah ataupun peroleh HKI minimal masing-masing 1 kali dalam setahun'
        => [
          [
            'Terdapat laporan kegiatan workshop pengembangan kompetensi penelitian, penulisan artikel, atau perolehan HKI',
          ],
          [
            'Melakukan rekap kegiatan pengembangan kompetensi penelitian yang dilaksanakan dalam satu tahun',
          ],
          [
            'LPPM',
            'KK',
            'SINO',
          ],
        ],

        // B SPM PPP
        'Rektor wajib memiliki rencana strategis perguruan tinggi'
        => [
          [
            'Terdapat dokumen rencana strategis institusi',
          ],
          [
            'Melakukan audit',
          ],
          [
            'IA',
            'LPPM',
            'SPMPPP',
          ],
        ],
        'Rektor wajib menetapkan target pencapaian penelitian di setiap tahun dalam bentuk Kontrak Manajemen'
        => [
          [
            'Terdapat dokumen rencana strategis institusi',
          ],
          [
            'Melakukan audit',
          ],
          [
            'LPPM',
            'IA',
            'SPMPPP',
          ],
        ],
        'Rektor wajib melakukan pemantauan dan evaluasi terhadap kinerja Bagian LPPM melalui rapat pencapaian kontrak manajemen setiap bulan'
        => [
          [
            'Terdapat Minute of Meeting (MoM) rapat review manajemen',
          ],
          [
            'Melakukan rapat review manajemen',
          ],
          [
            'LPPM',
            'IA',
            'SPMPPP',
          ],
        ],

        // Kerjasama
        'Rektor wajib memfasilitasi kerjasama penelitian antar perguruan tinggi atau dengan dunia industri'
        => [
          [
            'Terdapat MoU atau PKS  penelitian dengan perguruan tinggi dan dunia industri',
          ],
          [
            'Melakukan inisiasi kerjasama penelitian dengan perguruan tinggi dan dunia industri',
          ],
          [
            'LPPM',
            'KSAMA',
          ],
        ],

        // Perencanaan
        'Rektor wajib menyusun Rencana Kerja Manajerial (RKM) bidang penelitian setiap tahun'
        => [
          [
            'Terdapat dokumen RKM penelitian',
          ],
          [
            'Melakukan penyusunan Rencana Kinerja Manajerial',
          ],
          [
            'LPPM',
            'PREN',
          ],
        ],
      ], //15
      'Standar Pendanaan dan Pembiayaan Penelitian'
      => [
        'LPPM wajib menyediakan dana penelitian (internal dan eksternal) sesuai dengan standar akreditasi setiap tahunnya'
        => [
          [
            'Terdapat dokumen perencanaan (RKA) jumlah dana penelitian (internal dan eksternal) sebesar minimal 5% dari total dana operasional Perguruan Tinggi (PT)',
            'Ada bukti dana penelitian dari sumber internal dan eksternal per tahun yang terserap sesuai kontrak penelitian',
            'Ada bukti dana yang lengkap mengenai pengelolaan penelitian untuk membiayai : Manajemen Penelitian yang terdiri atas seleksi proposal, pemantauan dan evaluasi, pelaporan Penelitian, dan diseminasi hasil Penelitian; peningkatan kapasitas peneliti; dan insentif publikasi ilmiah atau insentif Kekayaan Intelektual (KI)',
          ],
          [
            'Menghitung persentase dana penelitian terhadap dana Perguruan Tinggi selama satu tahun',
          ],
          [
            'KUAN',
            'LPPM',
            'DOSEN',
            'KK',
            'MITRA',
          ],
        ],
        'LPPM wajib memfasilitasi perolehan dana penelitian eksternal dalam negeri baik dari Perguruan Tinggi maupun non Perguruan Tinggi setiap tahunnya'
        => [
          [
            'Terdapat dokumen perencanaan (RKA) jumlah perolehan dana penelitian dari pihak luar PT per tahun minimal sebesar 1,7%',
            'Ada bukti dana penelitian dari sumber eksternal dalam negeri per tahun yang terserap sesuai kontrak penelitian',
            'Ada bukti dana yang lengkap mengenai pengelolaan penelitian untuk membiayai : Manajemen Penelitian yang terdiri atas seleksi proposal, pemantauan dan evaluasi, pelaporan Penelitian, dan diseminasi hasil Penelitian; peningkatan kapasitas peneliti; dan insentif publikasi ilmiah atau insentif Kekayaan Intelektual (KI).',
          ],
          [
            'Menghitung jumlah perolehan dana penelitian di luar PT dalam negeri per tahun',
          ],
          [
            'KUAN',
            'LPPM',
            'DOSEN',
            'KK',
            'MITRA',
          ],
        ],
        'LPPM wajib memfasilitasi perolehan dana penelitian eksternal luar negeri baik dari Perguruan Tinggi maupun non Perguruan Tinggi setiap tahunnya'
        => [
          [
            'Terdapat dokumen perencanaan (RKA) Jumlah perolehan dana penelitian dari PT maupun non PT di Luar Negeri per tahun sebesar minimal 0,3%',
            'Ada bukti dana penelitian dari sumber eksternal di luar negeri per tahun yang terserap sesuai kontrak penelitian',
            'Ada bukti dana yang lengkap mengenai pengelolaan penelitian untuk membiayai : Manajemen Penelitian yang terdiri atas seleksi proposal, pemantauan dan evaluasi, pelaporan Penelitian, dan diseminasi hasil Penelitian; Peningkatan kapasitas peneliti; dan Insentif publikasi ilmiah atau insentif Kekayaan Intelektual (KI).',
          ],
          [
            'Menghitung jumlah perolehan dana penelitian dari PT maupun non PT di Luar Negeri per tahun',
          ],
          [
            'KUAN',
            'LPPM',
            'DOSEN',
            'KK',
            'MITRA',
          ],
        ],
        'LPPM wajib memfasilitasi dana penelitian dari internal PT setiap tahunnya'
        => [
          [
            'Terdapat dokumen perencanaan (RKA) jumlah dana penelitian internal sebesar minimal 3% dari total dana operasional PT',
            'Ada bukti dana penelitian dari sumber eksternal di luar negeri per tahun yang terserap sesuai kontrak penelitian',
            'Ada bukti dana yang lengkap mengenai pengelolaan penelitian untuk membiayai : Manajemen Penelitian yang terdiri atas seleksi proposal, pemantauan dan evaluasi, pelaporan Penelitian, dan diseminasi hasil Penelitian; Peningkatan kapasitas peneliti; dan Insentif publikasi ilmiah atau insentif Kekayaan Intelektual (KI).',
            //Keuangan
            'Insentif publikasi ilmiah atau insentif Kekayaan Intelektual (KI).',
          ],
          [
            'Menghitung jumlah pendanaan penelitian dari internal PT',
          ],
          [
            'KUAN',
            'LPPM',
            'KK',
            'DOSEN',
            //'MITRA',
          ],
        ],
      ], //16
    ];

    $standarKriteriaPengabdianMasyarakat = [
      'Standar Hasil Pengabdian kepada Masyarakat'
      => [
        'LPPM memastikan kegiatan pengabdian Dosen telah memenuhi kebutuhan masyarakat'
        => [
          [
            'Adanya hasil survei atau evaluasi kegiatan pengabdian masyarakat',
          ],
          [
            'Melakukan survei atau evaluasi pada setiap akhir kegiatan pengabdian masyarakat',
          ],
          [
            'DOSEN',
            'KK',
            'LPPM',
          ],
        ],
        'LPPM memastikan kegiatan pengabdian Dosen dapat menjadi bahan pengembangan ilmu pengetahuan dan teknologi atau sumber belajar bagi mahasiswa'
        => [
          [
            'Adanya bahan ajar sebagai sumber belajar bagi mahasiswa',
            'Adanya publikasi hasil pengabdian masyarakat  di Jurnal atau media massa',
          ],
          [
            'Menghitung jumlah publikasi pada jurnal atau prosiding atau media massa yang diperoleh dari hasil kegiatan pengabdian masyarakat.',
            'Menghitung jumlah bahan pengayaan sumber belajar yang dihasilkan kegiatan pengabdian masyarakat.',
          ],
          [
            'DOSEN',
            'KK',
            'LPPM',
          ],
        ],
        'Dosen yang melaksanakan pengabdian masyarakat harus memastikan bahwa hasil kegiatan pengabdian masyarakat telah memanfaatkan teknologi tepat guna untuk pemberdayaan dan peningkatan kesejahteraan masyarakat'
        => [
          [
            'Adanya teknologi tepat guna yang digunakan pada kegiatan pengabdian masyarakat',
          ],
          [
            'Melakukan rekap jumlah teknologi tepat guna yang digunakan dalam kegiatan pengabdian masyarakat',
          ],
          [
            'DOSEN',
            'KK',
            'LPPM',
          ],
        ],
      ], //17
      'Standar Isi Pengabdian kepada Masyarakat'
      => [
        // Sentra Inovasi
        'LPPM memastikan bahwa hasil penelitian diterapkan pada kegiatan pengabdian masyarakat'
        => [
          [
            'Adanya hasil penelitian berupa Jurnal, paten, model rekayasa sosial atau prototype produk teknologi tepat guna.yang digunakan pada kegiatan pengabdian masyarakat sebesar 30%',
          ],
          [
            'Melakukan rekap dan evaluasi setiap penilaian pengajuan usulan maupun laporan pengabdian masyarakat',
          ],
          [
            'LPPM',
            'KK',
          ],
        ],
        'LPPM memastikan bahwa pengembangan ilmu pengetahuan dan teknologi dapat memberdayakan masyarakat'
        => [
          [
            'Adanya kegiatan pengabdian masyarakat yang merupakan upaya pemberdayaan masyarakat sebanyak >/= 10%',
          ],
          [
            'Melakukan rekap dan evaluasi setiap penilaian pengajuan usulan maupun laporan pengabdian masyarakat',
          ],
          [
            'LPPM',
            'KK',
          ],
        ],
        'LPPM memastikan bahwa teknologi tepat guna dapat dimanfaatkan dalam rangka meningkatkan taraf hidup dan kesejahteraan masyarakat'
        => [
          [
            'Adanya teknologi tepat guna yang dapat meningkatkan taraf hidup dan kesejahteraan masyarakat sebanyak >/= 10%',
          ],
          [
            'Melakukan rekap dan evaluasi setiap penilaian pengajuan usulan maupun laporan pengabdian masyarakat',
          ],
          [
            'LPPM',
            'KK',
          ],
        ],
        'LPPM memastikan bahwa model pemecahan masalah, rekayasa sosial, dan/atau rekomendasi kebijakan yang dapat diterapkan langsung oleh masyarakat, dunia usaha, industri, dan/ atau pemerintah'
        => [
          [
            'Adanya penerapan model yang dapat digunakan dalam pemecahan masalah, rekayasa sosial, dan/ atau rekomendasi kebijakan sebanyak >/= 10%',
          ],
          [
            'Melakukan rekap dan evaluasi setiap penilaian pengajuan usulan maupun laporan pengabdian masyarakat',
          ],
          [
            'LPPM',
            'KK',
          ],
        ],
        'LPPM memastikan bahwa terdapat HKI yang dimanfaatkan oleh masyarakat, dunia usaha, dan/ atau industri'
        => [
          [
            'Terdapat paling sedikit 1 HKI yang dimanfaatkan oleh masyarakat, dunia industri, dan/atau industri',
          ],
          [
            'Melakukan rekap dan evaluasi setiap tahun',
          ],
          [
            'LPPM',
            'SINO',
            'KK',
          ],
        ],
      ], //18
      'Standar Pelaksana Pengabdian kepada Masyarakat'
      => [
        'Pelaksana pengabdian masyarakat wajib berpendidikan minimal Strata 2 (S2) atau magister dan memiliki portofolio dalam melakukan pengabdian masyarakat'
        => [
          [
            'Adanya ijazah S2 dan portofolio kegiatan pengabdian masyarakat',
          ],
          [
            'Mengecek portofolio pengabdian masyarakat dosen melalui portal sistem informasi',
            'Melakukan pengecekan kualifikasi dosen di data SDM',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
            'MITRA',
          ],
        ],
        'Pelaksana pengabdian masyarakat yang pernah menghasilkan paten atau HKI penelitian berhak mengajukan program berupa penerapan teknologi tepat guna di masyarakat'
        => [
          [
            'Terdapat dokumen pendaftaran paten atau HKI atas nama pelaksana pengabdian masyarakat',
          ],
          [
            'Mengecek di website direktorat jenderal kekayaan intelektual dan sertifikat',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
            'MITRA',
          ],
        ],
        'Pelaksana pengabdian masyarakat yang pernah melakukan penelitian dasar berhak mengajukan program pengabdian masyarakat berupa kegiatan pelayanan, peningkatan kapasitas, atau pemberdayaan masyarakat'
        => [
          [
            'Terdapat kesesuaian antara hasil penelitian dengan program pengabdian masyarakat',
          ],
          [
            'Melakukan evaluasi antara hasil penelitian dan program pengabdian masyarakat',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
            'MITRA',
          ],
        ],
      ], //19
      'Standar Pendanaan dan Pembiayaan Pengabdian kepada Masyarakat'
      => [
        'LPPM wajib menyediakan dana pengabdian (internal dan eksternal) masyarakat sesuai dengan standar akreditasi setiap tahunnya'
        => [
          [
            'Terdapat dokumen perencanaan (RKA) jumlah dana pengabdian masyarakat (internal dan eksternal) sebesar minimal 1% dari total dana operasional Perguruan Tinggi',
            'Ada bukti dana pengabdian masyarakat dari sumber internal per tahun yang terserap sesuai kontrak pengabdian masyarakat',
            'Ada bukti dana yang lengkap mengenai pengelolaan pengabdian masyarakat untuk membiayai: Manajemen Pengabdian masyarakat yang terdiri atas seleksi proposal, pemantauan dan evaluasi, pelaporan Pengabdian masyarakat, dan diseminasi hasil Pengabdian masyarakat; dan peningkatan kapasitas pelaksana',
          ],
          [
            'Menghitung persentase dana pengabdian masyarakat internal terhadap dana PT selama satu tahun',
          ],
          [
            'KUAN',
            'LPPM',
            'KK',
            'DOSEN',
            'MITRA',
          ],
        ],
        'LPPM wajib memfasilitasi perolehan dana pengabdian masyarakat eksternal dalam negeri baik dari Perguruan Tinggi maupun non Perguruan Tinggi setiap tahunnya'
        => [
          [
            'Terdapat dokumen perencanaan (RKA) jumlah perolehan dana pengabdian masyarakat dari pihak luar PT per tahun minimal sebesar  0,4%',
            'Ada bukti dana pengabdian masyarakat dari sumber eksternal dalam negeri per tahun yang terserap sesuai kontrak pengabdian masyarakat',
            'Ada bukti dana yang lengkap mengenai pengelolaan pengabdian masyarakat untuk membiayai : Manajemen Pengabdian masyarakat yang terdiri atas seleksi proposal, pemantauan dan evaluasi, pelaporan, dan diseminasi hasil Pengabdian masyarakat; dan peningkatan kapasitas pelaksana pengabdian masyarakat',
          ],
          [
            'Menghitung jumlah perolehan dana pengabdian masyarakat di luar PT dalam negeri per tahun',
          ],
          [
            'KUAN',
            'LPPM',
            'KK',
            'DOSEN',
            'MITRA',
          ],
        ],
        'LPPM wajib memfasilitasi perolehan dana pengabdian masyarakat eksternal luar negeri baik dari Perguruan Tinggi maupun non Perguruan Tinggi setiap tahunnya'
        => [
          [
            'Terdapat dokumen perencanaan (RKA) Jumlah perolehan dana pengabdian masyarakat dari PT maupun non PT di Luar Negeri per tahun sebesar minimal 0,1%',
            'Ada bukti dana pengabdian masyarakat dari sumber eksternal di luar negeri per tahun yang terserap sesuai kontrak pengabdian masyarakat',
            'Ada bukti dana yang lengkap mengenai pengelolaan pengabdian masyarakat untuk membiayai : Manajemen Pengabdian Masyarakat yang terdiri atas seleksi proposal, pemantauan dan evaluasi, pelaporan, dan diseminasi hasil Pengabdian masyarakat; dan Peningkatan kapasitas pelaksana pengabdian masyarakat',
          ],
          [
            'Menghitung jumlah perolehan dana pengabdian masyarakat dari PT di Luar Negeri per tahun',
          ],
          [
            'KUAN',
            'LPPM',
            'KK',
            'DOSEN',
            'MITRA',
          ],
        ],
        'LPPM wajib memfasilitasi dana penelitian dari internal PT setiap tahunnya'
        => [
          [
            'Terdapat dokumen perencanaan (RKA) jumlah dana pengabdian masyarakat internal sebesar minimal 0,5% dari total dana operasional PT',
            'Ada bukti dana pengabdian masyarakat dari sumber eksternal di luar negeri per tahun yang terserap sesuai kontrak pengabdian masyarakat',
            'Ada bukti dana yang lengkap mengenai pengelolaan pengabdian masyarakat untuk membiayai : Manajemen Pengabdian masyarakat yang terdiri atas seleksi proposal, pemantauan dan evaluasi, pelaporan, dan diseminasi hasil Pengabdian masyarakat; dan Peningkatan kapasitas pelaksana pengabdian masyarakat',
          ],
          [
            'Menghitung jumlah pendanaan pengabdian masyarakat dari internal PT',
          ],
          [
            'KUAN',
            'LPPM',
            'KK',
            'DOSEN',
          ],
        ],
      ], //20
      'Standar Pengelolaan Pengabdian kepada Masyarakat'
      => [
        'LPPM wajib melaksanakan pengabdian masyarakat dengan melakukan seleksi proposal dan pemantauan terhadap kemajuan pengabdian masyarakat pada tahun berjalan'
        => [
          [
            'Terdapat laporan seleksi proposal pengabdian masyarakat',
            'Terdapat Log book pengabdian masyarakat',
            'Terdapat laporan Monitoring dan evaluasi (Monev) kemajuan pengabdian masyarakat',
          ],
          [
            'Melakukan penilaian atau review terhadap proposal pengabdian masyarakat yang diajukan dosen',
            'Melakukan pengecekan terhadap logbook setiap pelaksana',
            'Melakukan monev yang dilaksanakan di pertengahan periode tahun pengabdian masyarakat',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
          ],
        ],
        'LPPM wajib melakukan monitoring dan evaluasi terhadap kegiatan pengabdian masyarakat yang sesuai antara Rencana Induk Pengabdian Masyarakat (RIP) dosen dan RIP institut setiap tahun'
        => [
          [
            'Terdapat dokumen laporan pengabdian masyarakat',
          ],
          [
            'Melakukan evaluasi terhadap progres akhir pengabdian masyarakat',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
          ],
        ],

        // Sentra Inovasi
        'LPPM bersama unit terkait wajib memfasilitasi kegiatan pengembangan kompetensi dosen dalam pengabdian masyarakat, penulisan artikel ilmiah ataupun peroleh HKI minimal masing-masing 1 kali dalam setahun'
        => [
          [
            'Terdapat laporan kegiatan workshop pengembangan kompetensi pengabdian masyarakat, penulisan artikel, atau perolehan HKI',
          ],
          [
            'Melakukan rekap kegiatan pengembangan kompetensi pengabdian masyarakat yang dilaksanakan dalam satu tahun',
          ],
          [
            'LPPM',
            'KK',
            'SINO',
          ],
        ],

        // SPM PPP && IA
        'Rektor wajib memiliki rencana strategis perguruan tinggi'
        => [
          [
            'Terdapat dokumen rencana strategis institusi',
          ],
          [
            'Melakukan audit',
          ],
          [
            'LPPM',
            'IA',
            'SPMPPP',
          ],
        ],
        'Rektor wajib melakukan pemantauan dan evaluasi terhadap kinerja Bagian LPPM melalui rapat pencapaian kontrak manajemen setiap bulan'
        => [
          [
            'Terdapat Minute of Meeting (MoM) rapat review manajemen',
          ],
          [
            'Melakukan rapat review manajemen',
          ],
          [
            'LPPM',
            'IA',
            'SPMPPP',
          ],
        ],

        // Internal Audit
        'Rektor harus memiliki Lembaga Pengabdian Masyarakat yang bertugas melakukan perencanaan, pelaksanaan, pengendalian, pemantauan dan evaluasi, serta pelaporan kegiatan pengabdian masyarakat berdasarkan prinsip pengelolaan yang baik'
        => [
          [
            'Adanya Lembaga Pengabdian Masyarakat yang telah termasuk di dalam SOTK institusi',
          ],
          [
            'Melakukan audit',
          ],
          [
            'REKTOR',
            'LPPM',
            'IA',
          ],
        ],
        'LPPM wajib merencanakan pengabdian masyarakat dengan menyusun rencana program, peraturan, dan panduan pelaksanaan pengabdian masyarakat yang dievaluasi setiap tahun'
        => [
          [
            'Terdapat dokumen rencana strategis pengabdian masyarakat, peraturan dan panduan pelaksanaan pengabdian masyarakat',
          ],
          [
            'Melakukan audit',
          ],
          [
            'LPPM',
            'KK',
            'IA',
          ],
        ],
        'Rektor wajib menetapkan target pencapaian pengabdian masyarakat di setiap tahun dalam bentuk Kontrak Manajemen'
        => [
          [
            'Terdapat dokumen KM bidang pengabdian masyarakat',
          ],
          [
            'Melakukan audit',
          ],
          [
            'LPPM',
            'IA',
          ],
        ],
        'Rektor wajib memfasilitasi kerjasama pengabdian masyarakat antar perguruan tinggi, pemerintah daerah atau dengan dunia industri'
        => [
          [
            'Terdapat MoU atau PKS  pengabdian masyarakat dengan perguruan tinggi, pemerintah daerah dan dunia industri',
          ],
          [
            'Melakukan audit',
          ],
          [
            'LPPM',
            'KSAMA',
            'IA',
          ],
        ],
        'Rektor wajib menyusun Rencana Kerja Manajerial (RKM) bidang pengabdian masyarakat setiap tahun'
        => [
          [
            'Terdapat dokumen RKM pengabdian masyarakat',
          ],
          [
            'Melakukan audit',
          ],
          [
            'LPPM',
            'IA',
          ],
        ],
      ], //21
      'Standar Penilaian Pengabdian kepada Masyarakat'
      => [
        'LPPM harus melaksanakan penilaian proses dan hasil pengabdian masyarakat secara terintegrasi dengan prinsip penilaian edukatif, objektif, akuntabel, dan transparan'
        => [
          [
            'Adanya kriteria dan prosedur penilaian untuk proses perencanaan, pelaksanaan maupun pelaporan pengabdian masyarakat',
            'Adanya Sistem informasi pengabdian masyarakat untuk menunjang proses penilaian',
          ],
          [
            'Melakukan rekap atau mereview terhadap kriteria dan prosedur penilaian  pengabdian masyarakat',
            'Melakukan monitoring pemenuhan kriteria maupun prosedur penilaian pada sistem informasi penilaian pengabdian masyarakat',
          ],
          [
            'LPPM',
            'DOSEN',
            'MHS',
            'KK',
          ],
        ],
        'LPPM harus menerapkan penilaian menggunakan metode dan instrumen yang relevan, akuntabel, dan dapat mewakili ukuran ketercapaian kinerja proses serta pencapaian kinerja pengabdian masyarakat.'
        => [
          [
            'Adanya tim reviewer internal pengabdian masyarakat',
            'Adanya penilaian yang dilakukan melalui presentasi oleh pelaksana pengabdian masyarakat',
          ],
          [
            'Dibuat surat keputusan rektor terkait tim reviewer internal pengabdian masyarakat',
            'Melakukan penilaian terhadap presentasi pelaksana pengabdian masyarakat',
          ],
          [
            'LPPM',
            'KK',
            'DOSEN',
            'MHS',
          ],
        ],
        'LPPM melakukan pengukuran kepuasan terhadap pelaksanaan pengabdian kepada masyarakat setiap akhir pelaksanaan pengabdian masyarakat'
        => [
          [
            'Terdapat bukti survei atau pengukuran nilai kepuasan masyarakat minimal 85',
          ],
          [
            'Melakukan survei pada masyarakat terkait kegiatan pengabdian masyarakat yang telah dilakukan',
          ],
          [
            'LPPM',
            'DOSEN',
          ],
        ],


        'LPPM wajib menetapkan rubrik penilaian pengabdian kepada masyarakat yang dipergunakan oleh reviewer untuk memberikan penilaian secara obyektif.'
        => [
          [
            'Terdapat rubrik penilaian pengabdian kepada masyarakat yang direview setiap tahun oleh LPPM',
          ],
          [
            'Melakukan review rubrik penilaian pengabdian kepada masyarakat setiap tahun untuk disesuaikan dengan regulasi terkini',
          ],
          [
            'LPPM',
            'TRVIEW',
          ],
        ],
      ], //22
      'Standar Proses Pengabdian kepada Masyarakat'
      => [
        'Dosen dan mahasiswa harus menjamin terlaksananya proses penjaminan mutu pada perencanaan, pelaksanaan dan pelaporan pengabdian masyarakat'
        => [
          [
            'Terdapat dokumen proposal pengabdian masyarakat yang diajukan oleh dosen dan mahasiswa',
            'Terdapat laporan kemajuan atau bimbingan pengabdian masyarakat',
            'Terdapat laporan  pengabdian masyarakat',
          ],
          [
            'Melakukan pengecekan ajuan proposal, laporan kemajuan, dan laporan pengabdian masyarakat di sistem informasi pengabdian masyarakat',
          ],
          [
            'DOSEN',
            'MHS',
            'LPPM',
          ],
        ],
        'Dosen wajib melaksanakan pengabdian masyarakat yang melibatkan mahasiswa sesuai dengan standar mutu pengabdian masyarakat serta mempertimbangkan standar keamanan, kenyamanan dan keselamatan pelaksana maupun lingkungan masyarakat'
        => [
          [
            'Terdapat petunjuk dan peralatan K3 untuk pengabdian masyarakat di laboratorium atau tempat pelaksanaan pengabdian masyarakat',
          ],
          [
            'Melakukan ceklist penggunaan peralatan K3 sesuai petunjuk penggunaan',
          ],
          [
            'DOSEN',
            'MHS',
            'LPPM',
          ],
        ],
        'Dosen dan mahasiswa yang melaksanakan pengabdian masyarakat wajib mempertimbangkan kegiatan dalam bentuk: Pelayanan kepada masyarakat; Penerapan ilmu pengetahuan dan teknologi sesuai dengan bidang keahliannya; Peningkatan kapasitas masyarakat; dan Pemberdayaan masyarakat'
        => [
          [
            'Adanya klasifikasi bentuk kegiatan pengabdian masyarakat yang meliputi: Pelayanan kepada masyarakat; Penerapan ilmu pengetahuan dan teknologi sesuai dengan bidang keahliannya; Peningkatan kapasitas masyarakat; dan Pemberdayaan masyarakat',
          ],
          [
            'Melakukan evaluasi kegiatan pengabdian masyarakat',
          ],
          [
            'DOSEN',
            'MHS',
            'LPPM',
          ],
        ],

        // KAPRODI
        'Program Studi memfasilitasi kegiatan pengabdian masyarakat mahasiswa sebagai program Merdeka Belajar Kampus Merdeka (MBKM) dan mendesain kurikulum Merdeka Belajar Kampus Merdeka (MBKM) untuk menjamin pencapaian IKU-5'
        => [
          [
            'Adanya Mahasiswa yang melaksanakan kegiatan MBKM maksimal 20 SKS yang meliputi kegiatan sebagai berikut: Membangun desa atau KKN Tematik; Mahasiswa mengajar; dan Proyek kemanusiaan',
          ],
          [
            'Melakukan evaluasi pelaksanaan MBKM pada kegiatan pengabdian masyarakat',
          ],
          [
            'PRODI',
          ],
        ],
      ], //23
      'Standar Sarana dan Prasarana Pengabdian kepada Masyarakat'
      => [
        'Rektor harus menyediakan sistem informasi layanan kegiatan pengabdian masyarakat'
        => [
          [
            'Kecepatan akses internet up to 1 MBps per orang',
          ],
          [
            'Melakukan pengukuran kecepatan akses internet secara berkala',
          ],
          [
            'ITS',
            'LPPM',
          ],
        ],

        //Kaur Lab && Perpus
        'Rektor harus menyediakan laboratorium dan peralatan penunjang yang mendukung kebutuhan pengabdian masyarakat'
        => [
          [
            'Adanya laboratorium dan peralatan penunjang yang disediakan di masing-masing fakultas',
          ],
          [
            'Melakukan pendataan aktivitas penelitian pada laboratorium dan peralatan penunjang',
          ],
          [
            //'Logistik', //LMA && Perpus
            'LPPM',
            'KAURLAB',
            'KK',
          ],
        ],

        //Logistik Aset
        'Rektor harus menjamin bahwa setiap laboratorium dilengkapi dengan alat pemadam kebakaran, P3K, K3 dan sarana penanganan limbah B3'
        => [
          [
            'Ketersediaan alat pemadam kebakaran, P3K, K3 dan sarana penanganan limbah B3 di setiap laboratorium',
          ],
          [
            'Melakukan rekap, memastikan keberadaan dan fungsinya,  serta melakukan pendataan  perlengkapan pemadam kebakaran, P3K, K3 dan penanganan limbah B3 di setiap laboratorium setiap bulan',
          ],
          [
            //'Logistik', //LMA && Perpus
            'LPPM',
          ],
        ],
      ], //24
    ];

    $standarKriteriaTambahan = [
      'Standar Kemahasiswaan'
      => [
        'Bagian kemahasiswaan harus mendukung kegiatan pembelajaran yang berorientasi kepada minat, bakat dan pencapaian prestasi lainnya secara periodik'
        => [
          [
            'Terdapat laporan kegiatan yang mendorong mahasiswa untuk berpartisipasi secara aktif dalam kegiatan kemahasiswaan pada level institusi atau eksternal',
            'Terdapat laporan pembinaan organisasi mahasiswa pada lingkup institusi',
            'Terdapat dokumen TAK untuk mahasiswa',
            'Terdapat laporan proses dokumen SKPI untuk mahasiswa',
            'Terdapat Unit Kegiatan Mahasiswa (UKM) yang dapat menjadi sarana meningkatkan bakat mahasiswa',
            'Terbentuknya struktur organisasi kemahasiswaan (BEM, DPM, HIMA, UKM)',
            'Adanya program kerja kegiatan mahasiswa',
          ],
          [
            'Melakukan tes minat dan bakat di awal kegiatan perkuliahan',
            'Memfasilitasi kegiatan Perguruan Tinggi yang melibatkan mahasiswa baik secara Akademik dan non Akademik',
            'Melakukan pendataan insentif bagi pencapaian prestasi di tingkat regional, nasional, atau nasional.',
            'Melakukan monitoring dan evaluasi pembinaan',
            'Melakukan audit',
          ],
          [
            'MHSN',
            'LPPM',
          ],
        ],
        'Bagian Kemahasiswaan melakukan pelayanan untuk mahasiswa secara sederhana dan mudah diakses serta disosialisasikan'
        => [
          [
            'Adanya pelayanan penanganan keluhan mahasiswa',
            'Adanya Bimbingan dan Konseling untuk mahasiswa.',
            'Adanya sarana dan prasarana untuk kegiatan Bimbingan dan Konseling.',
            'Adanya call center di unit kemahasiswaan berupa email atau forum diskusi lainnya seperti facebook ataupun kotak kritik dan saran',
            'Adanya sarasehan penanganan keluhan',
            'Adanya program Bimbingan dan Konseling',
            'Adanya dokumen panduan Bimbingan dan Konseling',
          ],
          [
            'Melakukan survei kepuasan mahasiswa',
            'Melakukan monitoring dan evaluasi kegiatan bimbingan dan konseling',
          ],
          [
            //'Logistik', ?? => LMA
            'BK',
            'MHSN',
          ],
        ],

        //Pemasaran & Admisi
        'Rektor harus mempunyai kebijakan penerimaan mahasiswa sesuai dengan peraturan Perguruan Tinggi (PT) yang telah ditetapkan dan ditinjau secara periodik'
        => [
          [
            'Adanya laporan melakukan penyebaran informasi kepada calon mahasiswa baru',
            'Adanya dokumen kebijakan untuk melakukan seleksi untuk calon mahasiswa baru',
            'Terdapat website Penerimaan Mahasiswa Baru (PMB) yang menyediakan info pendaftaran, hak dan kewajiban calon mahasiswa baru, serta link untuk untuk terhubung dengan admin admisi, data & pelaporan.',
            'Adanya laporan evaluasi bulanan terhadap promosi yang telah berjalan',
            'Adanya perbaikan sistem seleksi penerimaan calon mahasiswa baru',
          ],
          [
            'Melakukan kegiatan pemasaran direct marketing kepada siswa SMA/SMK/MA atau sederajat melalui expo, presentasi, atau seminar baik online maupun offline.',
            'Melakukan kegiatan pemasaran digital marketing melalui promote paid, ads, pamflet, brosur, atau baliho.',
            'Membuka program beasiswa internal.',
            'Melakukan monitoring dan evaluasi laporan akhir kegiatan PMB setelah closing PMB',
          ],
          [
            // Pemasaran & Admisi
            'PEAD',
          ],
        ],

        //Kesejahteraan mahassiwa
        'Rektor harus menyediakan beasiswa untuk mahasiswa'
        => [
          [
            'Adanya Surat Keputusan Rektor mengenai program beasiswa',
            'Adanya program Beasiswa Internal',
            'Adanya program Beasiswa  Eksternal',
          ],
          [
            'Melakukan monitoring dan evaluasi proses beasiswa untuk mahasiswa.',
            'Melakukan kegiatan pemasaran digital marketing melalui promote paid, ads, pamflet, brosur, atau baliho.',
            'Membuka program beasiswa internal.',
            'Melakukan monitoring dan evaluasi laporan akhir kegiatan PMB setelah closing PMB',
          ],
          [
            'KESKEM',
          ],
        ],
        'Rektor harus menyediakan fasilitas kesehatan yang memadai untuk mahasiswa'
        => [
          [
            'Tersedianya pelayanan kesehatan',
          ],
          [
            'Melakukan pendataan pengobatan gratis bagi mahasiswa.',
            'Melakukan monitoring terhadap jadwal dokter jaga.',
          ],
          [
            'KESKEM',
          ],
        ],

        //Kesejahteraan mahassiwa
        'Carrier Development Center (CDC) harus menyediakan layanan alumni dan tracer study'
        => [
          [
            'Terdapat Pusat Karir di tingkat Institusi',
            'Terdapat program peningkatan softskill dan kompetensi bagi lulusan',
            'Tersedianya sistem informasi bursa kerja untuk alumni',
            'Terdapat program workshop pengenalan dunia industri',
          ],
          [
            'Melakukan penggalangan dana melalui usaha bersama alumni dengan almamater untuk sarana bantuan kepada mahasiswa.',
            'Melakukan survei kepuasan pengguna alumni.',
            'Melakukan survei tracer study.',
            'Melakukan pembekalan bagi lulusan yang akan memasuki dunia kerja.',
          ],
          [
            'CDC',
          ],
        ],
      ], //25
      'Standar Kerjasama'
      => [
        // Kerjasama
        'Rektor, Wakil Rektor, Dekan, Ketua Program Studi, Kepala Bagian dan bagian Kerjasama sesuai kewenangan masing-masing harus melakukan pengembangan Kerjasama dalam negeri dan luar negeri agar dapat mendukung pencapaian visi misi ITTP setidaknya tahun 2023'
        => [
          [
            'Jumlah dan kualitas kerjasama dalam negeri dan luar negeri dapat mendukung pencapaian visi misi dan memenuhi 4 aspek sebagai berikut: Mutu kegiatan kerjasama; Relevansi kegiatan kerjasama; Produktifitas kegiatan kerjasama; dan Keberlanjutan kegiatan kerjasama',
            'Terdapat formulir inisiasi kerjasama',
            'Terdapat laporan pelaksanaan kegiatan kerjasama',
            'Terdapat laporan evaluasi mitra',
          ],
          [
            'Melakukan monitoring dan evaluasi inisiasi kerjasama',
            'Melakukan ketercapaian kerjasama berdasarkan data MoU/PKS',
            'Melakukan evaluasi kerjasama dengan Mitra',
          ],
          [
            'KSAMA',
            //'Seluruh unit yang melakukan kerjasama', ??
            'MITRA',
          ],
        ],
        'Rektor, Wakil Rektor, Dekan, Ketua Program Studi, Kepala Bagian dan bagian kerjasama sesuai kewenangan masing-masing melakukan monitoring dan evaluasi terhadap komponen kerjasama agar tercapai tingkat kepuasan stakeholder'
        => [
          [
            'Terdapat dokumen pedoman kerjasama',
            'Terdapat laporan evaluasi mitra',
          ],
          [
            'Melakukan monitoring dan evaluasi pelaksanaan hasil kerjasama secara berkala melalui : Pemantauan Implementasi MoU/PKS; Dokumen kegiatan dan hasil monitoring evaluasi kerjasama; Tingkat kepuasan stakeholder; Kesesuaian lingkup kerjasama; Pemantauan waktu berlaku MoU; dan Koordinasi antar unit',
          ],
          [
            'KSAMA',
            //'Seluruh unit yang melakukan kerjasama', ??
          ],
        ],
        'Rektor, Wakil Rektor, Dekan, Ketua Program Studi, Kepala Bagian dan bagian kerjasama sesuai kewenangan masing-masing melakukan dokumentasi terkait proses pengembangan kerjasama guna memberikan ketersediaan informasi yang meliputi informasi proses dan informasi ketercapaian proses yang telah berlangsung'
        => [
          [
            'Terdapat database pemantauan MoU/PKS',
            'Terdapat database pemantauan Kegiatan Kerjasama',
            'Adanya publikasi kegiatan kerjasama di website dan media sosial institusi',
          ],
          [
            'Melakukan audit',
          ],
          [
            'KSAMA',
            //'Seluruh unit yang melakukan kerjasama', ??
          ],
        ],
        'Rektor, Wakil Rektor, Dekan, Ketua Program Studi, Kepala Bagian dan bagian kerjasama sesuai kewenangan masing-masing harus melakukan pengembangan koordinasi konten MoU dan PKS yang meliputi kontrak manajemen, penelitian, pengabdian masyarakat, tukar menukar dosen dan / atau mahasiswa dalam penyelenggaraan kegiatan akademik , pemanfaatan bersama sumberdaya, penerbitan bersama karya ilmiah, penyelenggaraan bersama pertemuan ilmiah atau kegiatan ilmiah lain yang dianggap perlu, serta kerjasama profit maupun non profit dengan lembaga pemerintah dan industri di tingkat nasional maupun internasional'
        => [
          [
            'Terdapat jumlah MoU dan PKS dengan konten yang meliputi kontrak manajemen, penelitian, pengabdian masyarakat, tukar menukar dosen dan / atau mahasiswa dalam penyelenggaraan kegiatan akademik , pemanfaatan bersama sumberdaya, penerbitan bersama karya ilmiah, penyelenggaraan bersama pertemuan ilmiah atau kegiatan ilmiah lain yang dianggap perlu serta kerjasama profit maupun non profit dengan lembaga pemerintah dan industri di tingkat nasional maupun internasional',
            'Terdapat laporan pelaksanaan kegiatan kerjasama',
            'Terdapat laporan evaluasi mitra',
          ],
          [
            'Melakukan monitoring dan evaluasi inisiasi kerjasama',
            'Melakukan ketercapaian kerjasama berdasarkan data MoU/PKS',
            'Melakukan evaluasi kerjasama dengan Mitra',
          ],
          [
            'KSAMA',
            //'Seluruh unit yang melakukan kerjasama', ??
            'MITRA',
          ],
        ],
      ], //26
//      'Standar Kesejahteraan Pegawai', //27
    ];

    foreach ($standarKriteriaPembelajaran as $key => $standarKriteria) {
      $standarKriteriaCreated = StandarKriteria::create([
        'nama' => $key, 'kategori' => 'Standar Pendidikan'
      ]);

      foreach ($standarKriteria as $pernyataan => $indikators_unitKerjas) {
        $pernyataanStandarCreated = $standarKriteriaCreated->pernyataanStandars()->save(
          new PernyataanStandar(['pernyataan_standar' => $pernyataan])
        );

        // Creating Indikator
        foreach (collect($indikators_unitKerjas[0]) as $indikator) {
          $pernyataanStandarCreated->indikators()->save(
            new Indikator(['indikator' => $indikator])
          );
        }

        // Creating Indikator
        foreach (collect($indikators_unitKerjas[1]) as $measure) {
          $pernyataanStandarCreated->measures()->save(
            new Measure(['measure' => $measure])
          );
        }

        // Attach Pernyataan to Unit Kerja
        foreach (collect($indikators_unitKerjas[2]) as $unitKerjaId) {
          \DB::table('pernyataan_standar_unit_kerjas')
            ->insert([
              'unit_kerja_id' => UnitKerja::where( 'kode', $unitKerjaId)->first()->id,
              'standar_kriteria_id' => $standarKriteriaCreated->id,
              'pernyataan_standar_id' => $pernyataanStandarCreated->id,
            ]);
        }
      }
    }

    foreach ($standarKriteriaPenelitian as $key => $standarKriteria) {
      $standarKriteriaCreated = StandarKriteria::create([
        'nama' => $key, 'kategori' => 'Standar Pendidikan'
      ]);

      foreach ($standarKriteria as $pernyataan => $indikators_unitKerjas) {
        $pernyataanStandarCreated = $standarKriteriaCreated->pernyataanStandars()->save(
          new PernyataanStandar(['pernyataan_standar' => $pernyataan])
        );

        // Creating Indikator
        foreach (collect($indikators_unitKerjas[0]) as $indikator) {
          $pernyataanStandarCreated->indikators()->save(
            new Indikator(['indikator' => $indikator])
          );
        }

        // Creating Measures
        foreach (collect($indikators_unitKerjas[1]) as $measure) {
          $pernyataanStandarCreated->measures()->save(
            new Measure(['measure' => $measure])
          );
        }

        // Attach Pernyataan to Unit Kerja
        foreach (collect($indikators_unitKerjas[2]) as $unitKerjaId) {
          \DB::table('pernyataan_standar_unit_kerjas')
            ->insert([
              'unit_kerja_id' => UnitKerja::where( 'kode', $unitKerjaId)->first()->id,
              'standar_kriteria_id' => $standarKriteriaCreated->id,
              'pernyataan_standar_id' => $pernyataanStandarCreated->id,
            ]);
        }
      }
    }

    foreach ($standarKriteriaPengabdianMasyarakat as $key => $standarKriteria) {
      $standarKriteriaCreated = StandarKriteria::create([
        'nama' => $key, 'kategori' => 'Standar Pengabdian kepada Masyarakat'
      ]);

      foreach ($standarKriteria as $pernyataan => $indikators_unitKerjas) {
        $pernyataanStandarCreated = $standarKriteriaCreated->pernyataanStandars()->save(
          new PernyataanStandar(['pernyataan_standar' => $pernyataan])
        );

        // Creating Indikator
        foreach (collect($indikators_unitKerjas[0]) as $indikator) {
          $pernyataanStandarCreated->indikators()->save(
            new Indikator(['indikator' => $indikator])
          );
        }

        // Creating Measure
        foreach (collect($indikators_unitKerjas[1]) as $measure) {
          $pernyataanStandarCreated->measures()->save(
            new Measure(['measure' => $measure])
          );
        }

        // Attach Pernyataan to Unit Kerja
        foreach (collect($indikators_unitKerjas[2]) as $unitKerjaId) {
          \DB::table('pernyataan_standar_unit_kerjas')
            ->insert([
              'unit_kerja_id' => UnitKerja::where( 'kode', $unitKerjaId)->first()->id,
              'standar_kriteria_id' => $standarKriteriaCreated->id,
              'pernyataan_standar_id' => $pernyataanStandarCreated->id,
            ]);
        }
      }
    }

    foreach ($standarKriteriaTambahan as $key => $standarKriteria) {
      $standarKriteriaCreated = StandarKriteria::create([
        'nama' => $key, 'kategori' => 'Standar Tambahan'
      ]);

      foreach ($standarKriteria as $pernyataan => $indikators_unitKerjas) {
        $pernyataanStandarCreated = $standarKriteriaCreated->pernyataanStandars()->save(
          new PernyataanStandar(['pernyataan_standar' => $pernyataan])
        );

        // Creating Indikator
        foreach (collect($indikators_unitKerjas[0]) as $indikator) {
          $pernyataanStandarCreated->indikators()->save(
            new Indikator(['indikator' => $indikator])
          );
        }

        // Creating Measure
        $measuresCreated = [];
        foreach (collect($indikators_unitKerjas[1]) as $measure) {
          $measuresCreated[] = $pernyataanStandarCreated->measures()->save(
            new Measure(['measure' => $measure])
          );
        }

        // Attach Pernyataan to Unit Kerja
        foreach (collect($indikators_unitKerjas[2]) as $unitKerjaId) {
          \DB::table('pernyataan_standar_unit_kerjas')
            ->insert([
            'unit_kerja_id' => UnitKerja::where( 'kode', $unitKerjaId)->first()->id,
            'standar_kriteria_id' => $standarKriteriaCreated->id,
            'pernyataan_standar_id' => $pernyataanStandarCreated->id,
          ]);
        }
      }
    }
    // Standar Tambahan without Indikator and measures
    StandarKriteria::create([
      'nama' => 'Standar Kesejahteraan Pegawai',
      'kategori' => 'Standar Tambahan',
    ]);


    // Attach Measure to Unit kerja
    foreach (UnitKerja::all() as $item) {
      foreach ($item->pernyataanStandarUnitKerjas as $item2) {
        $measureIds = [];
        foreach ($item2->pernyataan_standar->measures as $measure) {
          if (\Arr::random([true, false])) {
            $measureIds[] = $measure->id;
          }
        }
        $item2->measures()->sync(collect($measureIds));
      }
    }
  }
}