<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
  use HasFactory;

  protected $keyType = 'string';

  protected $fillable = [
    'kode',
    'nama',
  ];

  protected $casts = [
    'id' => 'integer',
  ];

  public function getCreatedAtAttribute($value)
  {
    return \Carbon\Carbon::parse($value)
      ->locale(config('app.locale'))
      ->timezone(config('app.timezone'))
      ->isoFormat('LL');
  }

  public function getUpdatedAtAttribute($value)
  {
    return \Carbon\Carbon::parse($value)
      ->locale(config('app.locale'))
      ->timezone(config('app.timezone'))
      ->diffForHumans();
  }

  public function auditors()
  {
    return $this->hasMany(Auditor::class);
  }

  public function auditees()
  {
    return $this->hasMany(Auditee::class);
  }

  public function pernyataanStandarUnitKerjas()
  {
    return $this->hasMany(PernyataanStandarUnitKerja::class);
  }

  public function riwayat_audits()
  {
    return $this->hasMany(RiwayatAudit::class);
  }

  public function rencanaAudits()
  {
    return $this->hasManyThrough(RencanaAudit::class, RiwayatAudit::class);
  }

  public function checklistAudits()
  {
    return $this->hasManyThrough(ChecklistAudit::class, RiwayatAudit::class);
  }

  public function ptks()
  {
    return $this->hasManyThrough(PTK::class, RiwayatAudit::class);
  }

  public function attendances()
  {
    return $this->hasManyThrough(Attendance::class, RiwayatAudit::class);
  }
}
