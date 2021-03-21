<?php

namespace Tests\Utils;

use App\Utils\PasswordUtils;
use Illuminate\Http\Request;
use Tests\TestCase;

class PasswordHelperTest extends TestCase
{
    const MASTER_PASSWORD = 'w948t4w8j5t96k4yk64598tk45798dy5698y7k359ykd5679ykd3598y';
    const PASSWORD = "Hasło1234";
    const VALID_ENCRYPTED ="eyJpdiI6InFyQXdENmlkRHVraXFBTlVuQjdVZkE9PSIsInZhbHVlIjoiTkJuMitMK1pVL2xIQjRTMlgwQzdyQT09IiwibWFjIjoiYTY1NDA5YmRlNmM4Yzg1Y2FiNGM4ZGYzNDFhOGM2N2U4YzJjZGQ0NTkyNWQ0MWQwOGVjMGEwNTRjOTQ2OWU3MiJ9";

    const SALT = 'random salt i coś jeszcze!';
    const VALID_SALT = '5cb48b51f642abdb8959757a0084a7378f0acb6162e2b12f5b2a1d7762c2ba7304ceba2b5a7d371869d5573b3eb8b160b60a4f782baa3580002b047e957e30a9';

    public function testCreateHmacPassword()
    {
        $pregenHMAC = 'bc56900e7c1c7f0cf9cf368ba5dc67654ff92c58f4092d0117ef7dcba30efb2e';

        $value = PasswordUtils::createHmacPassword(self::PASSWORD);
        self::assertNotNull($value);
        self::assertEquals($pregenHMAC, $value);
    }

    public function testCreatePasswordWithSalt()
    {
        $value = PasswordUtils::createSaltPassword(self::PASSWORD, self::SALT);
        self::assertNotNull($value);
        self::assertEquals(self::VALID_SALT, $value);
    }

    public function testCreateWithOtherSalt() {
        $valueChangesSalt = PasswordUtils::createSaltPassword(self::PASSWORD, 'yufuyruyrruidlt');
        self::assertNotNull($valueChangesSalt);
        self::assertNotEquals(self::VALID_SALT, $valueChangesSalt);
    }

    public function testEncryptingPass()
    {
        $this->session(['master_password'=> substr(self::MASTER_PASSWORD, 5, 32)]);
        $value = PasswordUtils::encryptPassword(self::PASSWORD);
        // correct because password contain additional params that mark its as not edtited by user
        self::assertNotEquals(self::VALID_ENCRYPTED, $value);
    }

    public function testEncryptingPassWithoutSession()
    {
        $value = PasswordUtils::encryptPassword(self::PASSWORD);
        // should not decrypt and return instance of redirect
        self::assertNotEquals(self::VALID_ENCRYPTED, $value);
        self::assertInstanceOf('Illuminate\Http\RedirectResponse', $value);
    }

    public function testDecryptPass()
    {
        $this->session(['master_password' => substr(self::MASTER_PASSWORD, 5, 32)]);
        $decrypt1 = PasswordUtils::decryptPassword(self::VALID_ENCRYPTED);
        $decrypt2 = PasswordUtils::decryptPassword(PasswordUtils::encryptPassword(self::PASSWORD));

        self::assertNotNull($decrypt1);
        self::assertNotNull($decrypt2);
        //check if generated and pregen pasword are equal
        self::assertEquals($decrypt1, $decrypt2);
    }

    public function testDecryptRandomString()
    {
        //encrypted is broken lets check result
        $encrypted = "eyJpdkuuiI6Im1xhxeXlHN3Y0LzFETmZQdkZRRVE9PSIsInZhbHVlIjoidlljeGpZbyt5a2puUTV0eFAzVmpwdz09IiwibWFjIjoiMzg1NTE1YjI2NmJjMzI1OTzk1N2MzYjU2NDM4NThmZDAzNDZjMDRmNzQxYmYzNzY0M2Y0N2ZhYzdhMjY5NyJ9";

        $decrypt1 = PasswordUtils::decryptPassword($encrypted);
        self::assertNull($decrypt1);
        self::assertNotEquals(self::VALID_ENCRYPTED, $decrypt1);
    }
}
