<?php


namespace App\Utils;


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

}
