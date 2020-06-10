<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function onlyNumbers($value)
    {
        return preg_replace('/\D/', '', $value);
    }
    public function removeMaskDate($value)
    {
        $value = explode('/', $value);
        if (count($value) !== 3) {
            return $value;
        }

        return implode('-', array_reverse($value));
    }
    public function removeMaskMoney($value = '0,0')
    {
        if (strpos($value, ',')) {
            return floatval(str_replace(['.', ','], ['', '.'], $value));
        }
        return floatval($value);
    }
}
