<?php

namespace App\Util;

class AppUtil
{
    const PROJECT_NAME = 'KPORTAL';
    const APP_NAME = 'DICT';
    const BATCH_SIZE = 1000;

    public static function generateUuid($prefix = self::APP_NAME)
    {
        $now = new \DateTime();
        $now->modify(sprintf('+ %d seconds', rand(0, 59)));
        return sprintf('%s-%s-%s-%s', $prefix, date_format(new \DateTime(), 'YmdHis'), date_format($now, 's'), uniqid());
    }
}