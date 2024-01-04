<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAudit extends Model
{
  use HasFactory;

  protected $fillable = [
    'nomor_dokumen',
    'status_revisi',
    'tanggal_pembuatan',
    'halaman',
    'ketua_tim_auditor',
    'kaur_sai',
    'kabag_sekpim_legal_audit',

    'lokasi',
    'tanggal_rencana',
    'unit_kerja_id',
    'auditee_id',
    'ruang_lingkup_id'
  ];

  protected $casts = [
    'id' => 'integer',
  ];

  /**
   * @return string
   */
  public function getLogoIttp(): string
  {
    $logoBasePath = base_path('public/images/logo/logo-ittp.jpg');
    $type = pathinfo($logoBasePath, PATHINFO_EXTENSION);
    $data = file_get_contents($logoBasePath);

    return 'data:image/' . $type . ';base64,' . base64_encode($data);
  }

  public function scopeWithFilters($query, $ruang_lingkup)
  {
    return $query->when(count($ruang_lingkup), function ($query) use ($ruang_lingkup) {
      $query->whereIn('ruang_lingkup_id', $ruang_lingkup);
    });
  }

  public function ruang_lingkup()
  {
    return $this->belongsTo(RuangLingkup::class);
  }

  public function unit_kerja()
  {
    return $this->belongsTo(UnitKerja::class);
  }

  public function rencana_audits()
  {
    return $this->hasMany(RencanaAudit::class);
  }

  public function checklist_audits()
  {
    return $this->hasMany(ChecklistAudit::class);
  }

  public function ptks()
  {
    return $this->hasMany(PTK::class);
  }

  public function attendances()
  {
    return $this->hasMany(Attendance::class);
  }

  public function auditee()
  {
    return $this->belongsTo(Auditee::class);
  }

  public function auditors()
  {
    return $this
      ->belongsToMany(Auditor::class, 'auditor_riwayat_audit')
      ->orderBy('name');
  }
}
