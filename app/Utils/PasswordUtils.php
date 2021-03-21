<?php

namespace App\Utils;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;

class PasswordUtils
{

    /**
     * Generate password based on hmac password
     * @param $password
     * @return string
     */
    public static function createHmacPassword($password) {
        return hash_hmac('sha256', $password, 'super Tajne hasło');
    }

    /**
     * Create password with salt appended
     * @param $password
     * @param $salt
     * @return string
     */
    public static function createSaltPassword($password, $salt) {
        return hash('sha512', $password . $salt);
    }

    /**
     * Try to encrypt passsword when master password is set
     * @param $password
     * @return string
     */
    public static function encryptPassword($password) {
        try {
            $encrypter = new Encrypter(session()->get('master_password'), 'AES-256-CBC');
        } catch (Exception $e) {
            return redirect(route('master.index'));
        }

        return $encrypter->encryptString($password);
    }

    /**
     * Decrypt given password if master password was properly inputed
     * @param $passsword
     * @return string|null
     */
    public static function decryptPassword($passsword): ?string
    {
        try {
            if (empty(session()->get('master_password'))) {
                return null;
            }

            $decryptor = new Encrypter(session()->get('master_password'), 'AES-256-CBC');
            $decrypted = $decryptor->decryptString($passsword);
        } catch (DecryptException $e) {
            return null;
        }

        return $decrypted;
    }
}
