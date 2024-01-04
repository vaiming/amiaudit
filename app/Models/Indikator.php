<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
  use HasFactory;

  protected $fillable = [
    'indikator',
    'pernyataan_standar_id',
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

  public function pernyataanStandar()
  {
    return $this->belongsTo(PernyataanStandar::class);
  }

  public function checklistAudits()
  {
    return $this->hasMany(ChecklistAudit::class);
  }
}
