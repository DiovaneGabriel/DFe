<?php

namespace Libraries;

class Request
{

    public static function request($url, $kind, $content = false, $p_headers = false, $return_header = false, $timeout = false)
    {
        $timeout = $timeout ? $timeout : 30;
        $headers = [];
        $headers[] = "cache-control: no-cache";
        if ($p_headers) {
            $headers = array_merge($headers, $p_headers);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($kind));
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        if (in_array(strtoupper($kind), ["PUT", "POST"])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }

        if ($return_header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        $output = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        $return = (object) array(
            "code" => $code,
            "return" => $output,
            "error" => $error
        );

        if ($return_header) {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $return->header = trim(substr($output, 0, $header_size));
            $return->return = trim(substr($output, $header_size));
        }

        curl_close($ch);

        return $return;
    }

    public static function post($url, $data, $p_headers = false, $return_header = false, $timeout = false)
    {
        return self::request($url, "POST", $data, $p_headers, $return_header, $timeout);
    }
}
