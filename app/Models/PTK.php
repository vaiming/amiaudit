<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTK extends Model
{
  use HasFactory;

  protected $fillable = [
    'type',
    'problem', 'location', 'objective', 'reference',
    'analisa_akar_masalah',
    'akibat',
    'permintaan_tindakan_koreksi',
    'rencana_tindakan_perbaikan',
    'rencana_pencegahan',

    'repairing_datetime_start',
    'repairing_datetime_finish',
    'penanggung_jawab_perbaikan',

    'is_completed',
    'is_approved_by_auditee',
    'is_approved_by_auditor',
    'is_approved_with_repaired_by_auditor',

    'checklist_audit_id',
    'auditor_id',
    'auditee_id',
    'riwayat_audit_id',
  ];

  protected $casts = [
    'id' => 'integer',
    'is_approved_by_auditee' => 'boolean',
    'is_approved_by_auditor' => 'boolean',
    'is_approved_with_repaired_by_auditor' => 'boolean',
    'is_completed' => 'boolean',
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

  public function setTypeAttribute($value)
  {
    $this->attributes['type'] = strtolower($value);
  }

  public function getTypeAttribute($value)
  {
    return strtoupper($value);
  }

  public function riwayat_audit()
  {
    return $this->belongsTo(RiwayatAudit::class);
  }

  public function checklist_audit()
  {
    return $this->belongsTo(ChecklistAudit::class);
  }

  public function auditor()
  {
    return $this->belongsTo(Auditor::class);
  }

  public function auditee()
  {
    return $this->belongsTo(Auditee::class);
  }

  public function penanggungJawabPerbaikan()
  {
    return $this->belongsTo(UnitKerja::class, 'penanggung_jawab_perbaikan');
  }
}
