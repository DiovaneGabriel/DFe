<?php

namespace Libraries;

class Cache
{
    const CACHE_DIR = '/tmp/cache/';

    public static function getFromCache($key, $expiration = 3600)
    {
        $cacheFile = self::CACHE_DIR . md5($key);

        if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $expiration) {
            // Cache válido, retorna os dados armazenados
            return file_get_contents($cacheFile);
        }

        // Cache expirado ou não existente
        return false;
    }

    public static function saveToCache($key, $data)
    {
        mkdir(self::CACHE_DIR, 0777, true);

        $cacheFile = self::CACHE_DIR . md5($key);

        // Salva os dados em cache
        file_put_contents($cacheFile, $data);
    }
}
