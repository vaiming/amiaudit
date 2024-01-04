<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangLingkup extends Model
{
  use HasFactory;

  protected $fillable = [
    'tahun_ajaran_mulai',
    'tahun_ajaran_selesai',
    'semester'
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

  public function getRuangLingkupFormat()
  {
    return $this->tahun_ajaran_mulai . '/' .
      $this->tahun_ajaran_selesai . ' - '
      . \Str::ucfirst($this->semester);
  }

  public function riwayatAudits()
  {
    return $this->hasMany(RiwayatAudit::class);
  }
}
