<?php

namespace App\Util;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

class AwsS3Util
{
    const SDK_VERSION = 'latest';

    private static $instance = null;

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new AwsS3Util();
        }

        return self::$instance;
    }

    public function deleteObject($path)
    {
        $s3Client = $this->createClient();

        $bucket = getenv('S3_BUCKET');
        $directory = getenv('S3_DIRECTORY');
        $path = $directory.'/'.$path;

        // Delete an object from the bucket.
        $s3Client->deleteObject([
            'Bucket' => $bucket,
            'Key' => $path,
        ]);

        $apcuGetKey = 'GET_'.$path;
        if (apcu_exists($apcuGetKey)) {
            apcu_delete($apcuGetKey);
        }
    }

    private function createClient()
    {
        $accessKey = getenv('S3_ACCESS_KEY');
        $secretKey = getenv('S3_SECRET_KEY');
        $region = getenv('S3_REGION');
        $version = self::SDK_VERSION;

        $credentials = new Credentials($accessKey, $secretKey);

        $s3Client = new S3Client([
//            'profile' => 'default',
            'region' => $region,
            'version' => $version,
            'credentials' => $credentials,
        ]);
        return $s3Client;
    }

    public function getObjectReadUrl($path, $expr = '+7 days')
    {
        $apcuGetKey = 'GET_'.$path;
        if (apcu_exists($apcuGetKey)) {
            return apcu_fetch($apcuGetKey);
        }

        $bucket = getenv('S3_BUCKET');
        $directory = getenv('S3_DIRECTORY');
        $path = $directory.'/'.$path;

//        $version = self::SDK_VERSION;
//
//        $credentials = new Credentials($accessKey, $secretKey);
//
//
//        //Creating a presigned request
//        $s3Client = new S3Client([
////            'profile' => 'default',
//            'region' => $region,
//            'version' => $version,
//            'credentials' => $credentials,
//        ]);

        $s3Client = $this->createClient();

        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $path,
        ]);

        $request = $s3Client->createPresignedRequest($cmd, $expr);
        $url = (string) $request->getUri();

        apcu_store($apcuGetKey, $url,60*60*24*7);

        return $url;
    }

    public function getObjectWriteUrl($path, $expr = '+7 day')
    {
        $apcuPutKey = 'PUT_'.$path;
        if (apcu_exists($apcuPutKey)) {
            return apcu_fetch($apcuPutKey);
        }

        $bucket = getenv('S3_BUCKET');
        $directory = getenv('S3_DIRECTORY');
        $path = $directory.'/'.$path;

//        $version = self::SDK_VERSION;
//
//        $credentials = new Credentials($accessKey, $secretKey);
//
//
//        //Creating a presigned request
//        $s3Client = new S3Client([
////            'profile' => 'default',
//            'region' => $region,
//            'version' => $version,
//            'credentials' => $credentials,
//        ]);

        $s3Client = $this->createClient();

        $cmd = $s3Client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $path,
        ]);

        $request = $s3Client->createPresignedRequest($cmd, $expr);
        $url = (string) $request->getUri();

        apcu_store($apcuPutKey, $url,60*60*24*7);

        return $url;
    }
}
