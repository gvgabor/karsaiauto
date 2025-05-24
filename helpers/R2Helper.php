<?php

namespace app\helpers;

use Yii;

class R2Helper
{
    /**
     * Visszaadja a publikus URL-t az adott fájlhoz
     * $url = R2Helper::getUrl('autok/suzuki-swift-2020.webp');
     *
     * @param string $key Például: autok/valami.webp
     * @return string
     */
    public static function getUrl(string $key): string
    {
        $url = sprintf('https://pub-%s.r2.dev/%s', $_ENV['CLOUDFLARE_BUCKET_DEV_URL'], $_ENV['CLOUDFLARE_BUCKET_DIRECTORY']);
        return rtrim($url, '/') . '/' . ltrim($key, '/');
    }


}
