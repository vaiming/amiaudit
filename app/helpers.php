<?php

if (!function_exists('parse_date_to_iso_format')) {
  function parse_date_to_iso_format(string $stringDate): string
  {
    return \Carbon\Carbon::parse($stringDate)
      ->locale(config('app.locale'))
      ->timezone(config('app.timezone'))
      ->isoFormat('LL');
  }
}

if (!function_exists('parse_date_to_sql_date_format')) {
  function parse_date_to_sql_date_format(string $stringDate): string
  {
    return \Carbon\Carbon::parse($stringDate)
      ->locale(config('app.locale'))
      ->timezone(config('app.timezone'))
      ->format('Y-m-d');
  }
}