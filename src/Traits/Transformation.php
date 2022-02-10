<?php

namespace Hekmatinasser\Verta\Traits;

trait Transformation
{
    /**
     * gregorian to jalali convertion
     *
     * @param int $g_y
     * @param int $g_m
     * @param int $g_d
     * @return array
     */
    public static function getJalali($g_y, $g_m, $g_d)
    {
        $gy = $g_y - 1600;
        $gm = $g_m - 1;
        $g_day_no = (365 * $gy + intval(($gy + 3) / 4) - intval(($gy + 99) / 100) + intval(($gy + 399) / 400));
        for ($i = 0; $i < $gm; ++$i) {
            $g_day_no += static::$daysMonthGregorian[$i];
        }
        if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0))) {
            # leap and after Feb
            $g_day_no++;
        }
        $g_day_no += $g_d - 1;
        $j_day_no = $g_day_no - 79;
        $j_np = intval($j_day_no / 12053); # 12053 = (365 * 33 + 32 / 4)
        $j_day_no = $j_day_no % 12053;
        $jy = (979 + 33 * $j_np + 4 * intval($j_day_no / 1461)); # 1461 = (365 * 4 + 4 / 4)
        $j_day_no %= 1461;
        if ($j_day_no >= 366) {
            $jy += intval(($j_day_no - 1) / 365);
            $j_day_no = ($j_day_no - 1) % 365;
        }
        for ($i = 0; ($i < 11 && $j_day_no >= static::$daysMonthJalali[$i]); ++$i) {
            $j_day_no -= static::$daysMonthJalali[$i];
        }

        return [$jy, $i + 1, $j_day_no + 1];
    }

    /**
     * jalali to gregorian convertion
     *
     * @param int $j_y
     * @param int $j_m
     * @param int $j_d
     * @return array
     */
    public static function getGregorian($j_y, $j_m, $j_d)
    {
        $jy = $j_y - 979;
        $jm = $j_m - 1;
        $j_day_no = (365 * $jy + intval($jy / 33) * 8 + intval(($jy % 33 + 3) / 4));
        for ($i = 0; $i < $jm; ++$i) {
            $j_day_no += static::$daysMonthJalali[$i];
        }
        $j_day_no += $j_d - 1;
        $g_day_no = $j_day_no + 79;
        $gy = (1600 + 400 * intval($g_day_no / 146097)); # 146097 = (365 * 400 + 400 / 4 - 400 / 100 + 400 / 400)
        $g_day_no = $g_day_no % 146097;
        $leap = 1;
        if ($g_day_no >= 36525) { # 36525 = (365 * 100 + 100 / 4)
            $g_day_no--;
            $gy += (100 * intval($g_day_no / 36524)); # 36524 = (365 * 100 + 100 / 4 - 100 / 100)
            $g_day_no = $g_day_no % 36524;
            if ($g_day_no >= 365) {
                $g_day_no++;
            } else {
                $leap = 0;
            }
        }
        $gy += (4 * intval($g_day_no / 1461)); # 1461 = (365 * 4 + 4 / 4)
        $g_day_no %= 1461;
        if ($g_day_no >= 366) {
            $leap = 0;
            $g_day_no--;
            $gy += intval($g_day_no / 365);
            $g_day_no = ($g_day_no % 365);
        }
        for ($i = 0; $g_day_no >= (static::$daysMonthGregorian[$i] + ($i == 1 && $leap)); $i++) {
            $g_day_no -= (static::$daysMonthGregorian[$i] + ($i == 1 && $leap));
        }

        return [$gy, $i + 1, $g_day_no + 1];
    }
}
