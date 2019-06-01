<?php

namespace App\Util;

class AppUtil
{
    const PROJECT_NAME = 'KPORTAL';
    const APP_NAME = 'VOCAB';
    const BATCH_SIZE = 1000;

    public static function generateUuid($prefix = self::APP_NAME)
    {
        return sprintf('%s-%s-%s-%s', $prefix, date_format(new \DateTime(), 'YmdHis'), rand(0, 999), uniqid());
    }
}