<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaAudit extends Model
{
  use HasFactory;

  protected $fillable = [
    'sub_unit_kerja',
    'dokumen',
    'auditee_id',
    'auditor_id',
    'standar_kriteria_id',
    'riwayat_audit_id',
  ];

  protected $casts = [
    'id' => 'integer',
  ];

  public function getCreatedAtAttribute($value) {
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

  public function standarKriteria()
  {
    return $this->belongsTo(StandarKriteria::class);
  }

  public function auditee()
  {
    return $this->belongsTo(Auditee::class);
  }

  public function auditor()
  {
    return $this->belongsTo(Auditor::class);
  }
}
