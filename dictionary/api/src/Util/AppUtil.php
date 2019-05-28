<?php

namespace App\Util;

class AppUtil
{
    const PROJECT_NAME = 'KPORTAL';
    const APP_NAME = 'DICT';
    const BATCH_SIZE = 1000;

    public static function generateUuid($prefix = self::APP_NAME)
    {
        return sprintf('%s-%s-%s', $prefix, uniqid(), date_format(new \DateTime(), 'HidmY'));
    }
}