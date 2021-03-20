<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\PasswordController;
use App\Models\Password;
use Tests\TestCase;

class PasswordControllerTest extends TestCase
{

    public function testShow()
    {
        auth()->loginUsingId(9);
        $obj = new PasswordController();

        //todo proper work
        foreach(Password::all() as $passObj) {
            $result = $obj->show($passObj->id);

            self::assertEquals($result->getStatusCode(), 200);
            self::assertJson($result->getContent());
        }
    }
}
