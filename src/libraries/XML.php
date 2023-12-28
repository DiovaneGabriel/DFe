<?php

namespace Libraries;

class XML
{

    public static function createFromArray($array, $node_name = '', $replace = null)
    {
        $xml = '';
        if (is_array($array) || is_object($array)) {
            foreach ($array as $key => $value) {
                if (is_numeric($key)) {
                    $key = $node_name;
                }

                if ($replace && is_array($replace)) {
                    foreach ($replace as $val) {
                        if (substr($key, 0, strlen($val)) === $val) {
                            $key = $val;
                        }
                    }
                }

                if (strpos($key, '#') !== false) {
                    $key = explode('#', $key)[0];
                }

                $closure = explode(' ', $key);
                if ($value !== null) {
                    $xml .= '<' . $key . '>' . self::createFromArray($value, $node_name, $replace) . '</' . $closure[0] . '>';
                }
            }
        } else {
            $xml = $array;
        }

        return $xml;
    }
}