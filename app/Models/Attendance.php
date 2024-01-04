<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'origin',
    'riwayat_audit_id',
  ];

  protected $casts = [
    'id' => 'integer',
  ];

  public function riwayat_audit()
  {
    return $this->belongsTo(RiwayatAudit::class);
  }
}
