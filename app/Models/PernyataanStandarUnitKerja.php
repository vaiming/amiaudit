<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PernyataanStandarUnitKerja extends Model
{
  use HasFactory;
  public $timestamps = false;

  protected $fillable = [
    'unit_kerja_id',
    'standar_kriteria_id',
    'pernyataan_standar_id',
  ];

  protected $casts = [
    'id' => 'integer'
  ];

  public function standarKriteria()
  {
    return $this->belongsTo(StandarKriteria::class);
  }

  public function pernyataan_standar()
  {
    return $this->belongsTo(PernyataanStandar::class);
  }

  public function measures()
  {
    return $this->belongsToMany(Measure::class, 'measure_unit_kerja');
  }
}
