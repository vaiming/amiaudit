<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarKriteria extends Model
{
  use HasFactory;

  protected $fillable = [
    'nama',
    'kategori',
  ];
  protected $casts = [
    'id' => 'integer',
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

  public function pernyataanStandars()
  {
    return $this->hasMany(PernyataanStandar::class);
  }

  public function pernyataanStandarUnitKerjas()
  {
    return $this->hasMany(PernyataanStandarUnitKerja::class);
  }

  public function rencanaAudits()
  {
    return $this->hasMany(RencanaAudit::class);
  }

  public function checklistAudits()
  {
    return $this->hasMany(ChecklistAudit::class);
  }

  public function indikators()
  {
    return $this->hasManyThrough(Indikator::class, PernyataanStandar::class);
  }

  public function measures()
  {
    return $this->hasManyThrough(Measure::class, PernyataanStandar::class);
  }
}
