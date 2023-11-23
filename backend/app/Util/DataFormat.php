<?php

namespace App\Util;

class DataFormat
{
    public static function unmask($value)
    {
        return preg_replace('/[^0-9]/', '', $value);

    }
}
