<?php


namespace App;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public static function formatMoney($value, $currency = 'R$')
    {
        return $currency . number_format($value, 2, ',', '.');
    }

    public static function onlyNumbers($value)
    {
        return preg_replace('/\D/', '', $value);
    }
    public static function removeMaskDate($value)
    {
        $value = explode('/', $value);
        if (count($value) !== 3) {
            return $value;
        }

        return implode('-', array_reverse($value));
    }
    public static function removeMaskMoney($value = '0,0')
    {
        if (strpos($value, ',')) {
            return floatval(str_replace(['.', ','], ['', '.'], $value));
        }
        return floatval($value);
    }
}
