<?php

/**
 * app/Helpers/DateHelper.php
 *
 * Helper konversi format tanggal & jam (memakai Carbon, bawaan Laravel).
 * Zona waktu default mengikuti config('app.timezone').
 */

use Carbon\Carbon;

if (! function_exists('parse_date')) {
    /**
     * Ubah input apa pun (string / Carbon / DateTime) menjadi objek Carbon.
     * Kalau format input tidak standar, isi $from, misalnya 'd/m/Y'.
     * Mengembalikan null bila kosong atau tidak valid.
     */
    function parse_date($date, ?string $from = null, ?string $tz = null): ?Carbon
    {
        if (blank($date)) {
            return null;
        }

        $tz ??= config('app.timezone');

        try {
            if ($date instanceof DateTimeInterface) {
                return Carbon::instance($date)->setTimezone($tz);
            }

            return $from
                ? Carbon::createFromFormat($from, $date, $tz)
                : Carbon::parse($date, $tz);
        } catch (Throwable $e) {
            return null;
        }
    }
}

if (! function_exists('format_date')) {
    /** 2026-12-25 => 25 Desember 2026 */
    function format_date($date, string $format = 'd F Y', ?string $from = null): ?string
    {
        return parse_date($date, $from)?->locale('id')->translatedFormat($format);
    }
}

if (! function_exists('format_time')) {
    /** 2026-12-25 14:30:00 => 14:30 */
    function format_time($date, string $format = 'H:i', ?string $from = null): ?string
    {
        return parse_date($date, $from)?->translatedFormat($format);
    }
}

if (! function_exists('format_datetime')) {
    /** 2026-12-25 14:30:00 => 25 Desember 2026, 14:30 */
    function format_datetime($date, string $format = 'd F Y, H:i', ?string $from = null): ?string
    {
        return parse_date($date, $from)?->locale('id')->translatedFormat($format);
    }
}

if (! function_exists('convert_date_format')) {
    /** Ubah format string tanggal: convert_date_format('25/12/2026', 'd/m/Y', 'Y-m-d') => 2026-12-25 */
    function convert_date_format(?string $date, string $from, string $to): ?string
    {
        return parse_date($date, $from)?->format($to);
    }
}

if (! function_exists('to_db_date')) {
    /** Dari input form (d/m/Y) ke format database (Y-m-d). */
    function to_db_date(?string $date, string $from = 'd/m/Y'): ?string
    {
        return convert_date_format($date, $from, 'Y-m-d');
    }
}

if (! function_exists('to_db_datetime')) {
    /** Dari input form (d/m/Y H:i) ke format database (Y-m-d H:i:s). */
    function to_db_datetime(?string $date, string $from = 'd/m/Y H:i'): ?string
    {
        return convert_date_format($date, $from, 'Y-m-d H:i:s');
    }
}

if (! function_exists('time_ago')) {
    /** 2 jam yang lalu, 3 hari yang lalu, dst. */
    function time_ago($date): ?string
    {
        return parse_date($date)?->locale('id')->diffForHumans();
    }
}

if (! function_exists('convert_timezone')) {
    /** Ubah zona waktu: convert_timezone('2026-12-25 14:30:00', 'Asia/Jayapura') */
    function convert_timezone($date, string $toTz, string $format = 'Y-m-d H:i:s', ?string $fromTz = null): ?string
    {
        return parse_date($date, null, $fromTz)?->setTimezone($toTz)->format($format);
    }
}
