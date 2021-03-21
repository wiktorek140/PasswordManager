<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\PasswordController;
use App\Models\Password;
use App\Models\User;
use App\Utils\PasswordUtils;
use Tests\TestCase;

class PasswordControllerTest extends TestCase
{

    public function testShow()
    {
        $user = User::factory()->create(['isHmac' => 0]);
        auth()->login($user);
        $obj = new PasswordController();
        $this->session(['master_password' => substr('4875634785643875683746587437865874', 0, 32)]);
        $pasword = Password::factory()->create(['user_id'=> $user->id, 'password' =>PasswordUtils::encryptPassword('password_key')]);

        foreach(Password::all() as $passObj) {
            $result = $obj->show($passObj->id);

            self::assertEquals($result->getStatusCode(), 200);
            self::assertJson($result->getContent());
            $res = json_decode($result->getContent());
            if (isset($res->password)) {
                self::assertEquals($res->password, 'password_key');
            }
        }

        $pasword->delete();
        $user->delete();
    }
}
