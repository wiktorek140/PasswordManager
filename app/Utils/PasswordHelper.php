<?php


namespace App\Utils;


use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class PasswordHelper
{

    public function _createHmacPassword($password) {
        return hash_hmac('sha256', $password, 'super Tajne hasło');
    }

    public function _createSaltPassword($password, $salt) {
        return hash('sha512', $password.$salt);
    }

    public static function createHmacPassword($password) {
        return hash_hmac('sha256', $password, 'super Tajne hasło');
    }

    public static function createSaltPassword($password, $salt) {
        return hash('sha512', $password.$salt);
    }

    public static function encryptPassword($password) {
       return Crypt::encryptString($password);
    }

    public static function decryptPassword($passsword): ?string
    {
        try {
            $decrypted = Crypt::decryptString($passsword);
        } catch (DecryptException $e) {
            return null;
        }

        return $decrypted;
    }

}
