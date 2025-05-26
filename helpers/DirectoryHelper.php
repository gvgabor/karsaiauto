<?php

namespace app\helpers;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Yii;

// Hasznos segítő a fájlműveletekhez

class DirectoryHelper
{
    /**
     * Rekurzívan kiszámolja egy könyvtár méretét bájtban.
     *
     * @param string $path A könyvtár elérési útja.
     * @return int|false A könyvtár mérete bájtban, vagy false hiba esetén.
     */
    public static function getDirectorySize(string $path)
    {
        if (!is_dir($path)) {
            // Yii::warning("A megadott elérési út nem könyvtár: $path");
            return false;
        }

        $totalSize = 0;

        try {
            // Iterátor a könyvtár bejárásához, rekurzívan
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $item) {
                if ($item->isFile()) {
                    $totalSize += $item->getSize();
                }
            }

            return $totalSize;
        } catch (Exception $exception) {
            Yii::error("Hiba történt a könyvtár méretének számítása során ($path): " . $exception->getMessage());
            return false;
        }
    }

    /**
     * Formázza a bájtokat emberi olvasható formátumba (pl. KB, MB, GB).
     *
     * @param int $bytes A méret bájtban.
     * @param int $decimals Tizedesjegyek száma.
     * @return string
     */
    public static function formatBytes(int $bytes, int $decimals = 2): string
    {
        $size   = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)) . ' ' . $size[$factor];
    }
}
