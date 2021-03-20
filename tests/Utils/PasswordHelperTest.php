<?php

namespace Tests\Utils;

use App\Utils\PasswordHelper;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class PasswordHelperTest extends TestCase
{

    const PASSWORD = "Hasło1234";
    const VALID_ENCRYPTED ="eyJpdiI6Im1xZ1hxeXlHN3Y0LzFETmZQdkZRRVE9PSIsInZhbHVlIjoidlljeGpZbyt5a2puUTV0eFAzVmpwdz09IiwibWFjIjoiMzg1NTE1YjI2NmJjMzI1OTMxYzk1N2MzYjU2NDM4NThmZDAzNDZjMDRmNzQxYmYzNzY0M2Y0N2ZhYzdhMjY5NyJ9";

    const SALT = 'random salt i coś jeszcze!';
    const VALID_SALT = '5cb48b51f642abdb8959757a0084a7378f0acb6162e2b12f5b2a1d7762c2ba7304ceba2b5a7d371869d5573b3eb8b160b60a4f782baa3580002b047e957e30a9';

    public function testEncryptPassword()
    {
        $value = PasswordHelper::encryptPassword(self::PASSWORD);

        // correct because password contain additional params that mark its as not edtited by user
        self::assertNotEquals(self::VALID_ENCRYPTED, $value);
    }

    public function testDecryptPassword()
    {
        $decrypt1 = PasswordHelper::decryptPassword(self::VALID_ENCRYPTED);
        $decrypt2 = PasswordHelper::decryptPassword(PasswordHelper::encryptPassword(self::PASSWORD));

        self::assertNotNull($decrypt1);
        self::assertNotNull($decrypt2);
        self::assertEquals($decrypt1, $decrypt2);
    }

    public function testDecryptRandomString()
    {
        //encrypted is broken lets check result
        $encrypted = "eyJpdkuuiI6Im1xhxeXlHN3Y0LzFETmZQdkZRRVE9PSIsInZhbHVlIjoidlljeGpZbyt5a2puUTV0eFAzVmpwdz09IiwibWFjIjoiMzg1NTE1YjI2NmJjMzI1OTzk1N2MzYjU2NDM4NThmZDAzNDZjMDRmNzQxYmYzNzY0M2Y0N2ZhYzdhMjY5NyJ9";

        $decrypt1 = PasswordHelper::decryptPassword($encrypted);
        self::assertNull($decrypt1);
        self::assertNotEquals(self::VALID_ENCRYPTED, $decrypt1);
    }

    public function testCreateHmacPassword()
    {
        $pregenHMAC = 'bc56900e7c1c7f0cf9cf368ba5dc67654ff92c58f4092d0117ef7dcba30efb2e';

        $value = PasswordHelper::createHmacPassword(self::PASSWORD);
        self::assertNotNull($value);
        self::assertEquals($pregenHMAC, $value);
    }

    public function testCreateSaltPassword()
    {
        $value = PasswordHelper::createSaltPassword(self::PASSWORD, self::SALT);
        self::assertNotNull($value);
        self::assertEquals(self::VALID_SALT, $value);
    }

    public function testCreateWithOtherSalt() {
        $valueChangesSalt = PasswordHelper::createSaltPassword(self::PASSWORD, 'inny salt');
        self::assertNotNull($valueChangesSalt);
        self::assertNotEquals(self::VALID_SALT, $valueChangesSalt);
    }
}
