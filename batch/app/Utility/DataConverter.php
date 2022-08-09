<?php

namespace App\Utility;

use finfo;

class DataConverter
{
    public static function convertDataBase64(string $dataInBinaryFormat): string
    {
        return base64_encode($dataInBinaryFormat);
    }

    public static function getMimeType(string $dataInBinaryFormat): string
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        return $finfo->buffer($dataInBinaryFormat);
    }
}
