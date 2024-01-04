<?php

namespace App\Models;

use App\Traits\HasProfilePhoto;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Auditee extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, HasProfilePhoto;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'username',
    'email',
    'password',
    'unit_kerja_id',
    'profile_photo_path',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'id' => 'integer',
    'email_verified_at' => 'datetime',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  protected $appends = [
    'role_name',
    'profile_photo_url',
  ];

  public function getRoleNameAttribute()
  {
    return 'auditee';
  }

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

  public function unitKerja()
  {
    return $this->belongsTo(UnitKerja::class);
  }

  public function riwayat_audits()
  {
    return $this->hasMany(RiwayatAudit::class);
  }

  public function rencana_audits()
  {
    return $this->hasMany(RencanaAudit::class);
  }

  public function checklist_audits()
  {
    return $this->hasMany(ChecklistAudit::class);
  }

  public function ptks()
  {
    return $this->hasMany(PTK::class);
  }

  public function attendances()
  {
    return $this->hasMany(Attendance::class);
  }
}
