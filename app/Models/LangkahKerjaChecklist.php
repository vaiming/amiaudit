<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LangkahKerjaChecklist extends Model
{
  use HasFactory;

  protected $fillable = [
    'langkah_kerja',
    'checklist_audit_id',
    'is_audited'
  ];

  protected $casts = [
    'id' => 'integer',
    'is_audited' => 'boolean'
  ];

  public function checklist_audit()
  {
    return $this->belongsTo(ChecklistAudit::class);
  }
}