<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 19/07/2017
 * Time: 00:32
 */

namespace FileSharing\Service;


class Util
{
    public static function fileUploadMaxSize()
    {
        $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $max_size = self::parseSize(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parseSize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }

        return $max_size;
    }

    public static function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getBaseUrl()
    {
        $baseUrl = '';

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $baseUrl .= 'https';
        } else {
            $baseUrl .= 'http';
        }

        $baseUrl .= '://';

        $baseUrl .= $_SERVER['SERVER_NAME'];

        $baseUrl .= ':' . $_SERVER['SERVER_PORT'];

        return $baseUrl;
    }
}