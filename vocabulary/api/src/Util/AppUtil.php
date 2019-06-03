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


    public static function copyObjectScalarProperties($source, $dest)
    {
        $props = get_object_vars($source);
        $nonScalarProps = [];
        foreach ($props as $prop => $val) {
//            if ($prop === 'id' || $prop === 'uuid') {
//                continue;
//            }
//            echo 'prop is '.$prop.'  ';
            if (is_scalar($val)) {
                $setter = 'set'.ucfirst(strtolower($prop));
                if (method_exists($dest, $setter)) {
                    $dest->{$setter}($val);
                }
            } else {
                $nonScalarProps[$prop] = $val;
            }
        }
        return $nonScalarProps;
    }
}