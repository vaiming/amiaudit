<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PernyataanStandar extends Model
{
  use HasFactory;

  protected $fillable = [
    'pernyataan_standar',
    'standar_kriteria_id'
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

  public function unitKerjas()
  {
    return $this->belongsToMany(
      UnitKerja::class,
      'pernyataan_standar_unit_kerjas'
    );
  }

  public function standarKriteria()
  {
    return $this->belongsTo(StandarKriteria::class);
  }

  public function pernyataanStandarUnitKerjas()
  {
    return $this->hasMany(PernyataanStandarUnitKerja::class);
  }

  public function indikators()
  {
    return $this->hasMany(Indikator::class);
  }

  public function measures()
  {
    return $this->hasMany(Measure::class);
  }
}