<?php

namespace App\Util;

use App\Message\Entity\OrganisationSupportedType;
use Doctrine\ORM\EntityManagerInterface;

class AppUtil
{
    const PROJECT_NAME = 'KPORTAL';
    const BATCH_SIZE = 1000;
    const APP_NAME = 'USER';
    const TOPIC_ARN = '';

    public static function getFullAppName($name)
    {
        $names = ['ORG' => 'Organisation',
        ];
        return $names[$name];
    }



    public static function generateUuid($prefix = self::APP_NAME)
    {
        return sprintf('%s-%s-%s-%s', $prefix, date_format(new \DateTime(), 'YmdHis'), rand(0, 999), uniqid());
    }

    public static function copyObjectScalarProperties($source, $dest)
    {
        $props = get_object_vars($source);
        $nonScalarProps = [];
        foreach ($props as $prop => $val) {
            if ($prop === 'id') {
                continue;
            }

            echo 'prop is '.$prop.'  ';
            if (is_scalar($val)) {
                $setter = 'set'.ucfirst(strtolower($prop));
                $dest->{$setter}($val);
            } else {
                $nonScalarProps[$prop] = $val;
            }
        }
        return $nonScalarProps;
    }
}