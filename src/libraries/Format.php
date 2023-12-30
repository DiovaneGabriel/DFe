<?php

namespace Libraries;

class Format
{
    public static function mask($value, $mask)
    {
        $masked = null;
        while (strlen($value) > 0 && strlen($mask) > 0) {
            if (substr($mask, 0, 1) == '#') {
                $masked .= substr($value, 0, 1);
                $value = substr($value, 1, strlen($value) - 1);
                $mask = substr($mask, 1, strlen($mask) - 1);
            } else {
                $masked .= substr($mask, 0, 1);
                $mask = substr($mask, 1, strlen($mask) - 1);
            }
        }
        return $masked;
    }

    public static function cnpj($cnpj)
    {
        if (!$cnpj) {
            return null;
        }

        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

        $masked = self::mask($cnpj, '##.###.###/####-##');

        return $masked;
    }

    public static function floatWithComa(float $value): string
    {
        return str_replace(".", ",", $value);
    }
}
