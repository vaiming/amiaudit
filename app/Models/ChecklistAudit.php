<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistAudit extends Model
{
  use HasFactory;

  protected $fillable = [
    'standar_kriteria_id',
    'pernyataan_standar_id',
    'indikator_id',
    'measure_id',
    'tentatif_audit_objektif',
    'tujuan',
    'is_approved_by_admin',
    'is_approved_by_auditor',
    'is_marked_as_audit_completed',
    'is_marked_as_ptk',
    'auditor_id',
    'auditee_id',
    'riwayat_audit_id',
  ];

  protected $casts = [
    'id' => 'integer',
    'is_approved_by_admin' => 'boolean',
    'is_approved_by_auditor' => 'boolean',
    'is_marked_as_audit_completed' => 'boolean',
    'is_marked_as_ptk' => 'boolean',
  ];

  public function getCreatedAtAttribute($value)
  {
    return Carbon::parse($value)
      ->locale(config('app.locale'))
      ->timezone(config('app.timezone'))
      ->isoFormat('LL');
  }

  public function getUpdatedAtAttribute($value)
  {
    return Carbon::parse($value)
      ->locale(config('app.locale'))
      ->timezone(config('app.timezone'))
      ->diffForHumans();
  }

  public function riwayat_audit()
  {
    return $this->belongsTo(RiwayatAudit::class);
  }

  public function langkah_kerja_checklists()
  {
    return $this->hasMany(LangkahKerjaChecklist::class);
  }

  public function standarKriteria()
  {
    return $this->belongsTo(StandarKriteria::class);
  }

  public function pernyataan_standar()
  {
    return $this->belongsTo(PernyataanStandar::class);
  }

  public function indikator()
  {
    return $this->belongsTo(Indikator::class);
  }

  public function measure()
  {
    return $this->belongsTo(Measure::class);
  }

  public function auditee()
  {
    return $this->belongsTo(Auditee::class);
  }

  public function auditor()
  {
    return $this->belongsTo(Auditor::class);
  }

  public function ptk()
  {
    return $this->hasOne(PTK::class);
  }
}