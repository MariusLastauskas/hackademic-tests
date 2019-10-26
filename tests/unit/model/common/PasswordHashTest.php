<?php

namespace Tests\Unit;

use PasswordHash;

$passwordHash = null;
class PasswordHashTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        global $passwordHash;
        $passwordHash = new PasswordHash(1, true);
    }

    public function testGetRandomBytes()
    {
        global $passwordHash;

        $this->assertTrue(strlen($passwordHash->get_random_bytes(0)) == 0);
        $this->assertTrue(strlen($passwordHash->get_random_bytes(10)) == 10);
        $this->assertTrue(strlen($passwordHash->get_random_bytes(100)) == 100);
    }

    public function testEncode64()
    {
        global $passwordHash;

        $this->assertEquals($passwordHash->encode64('password', 6), 'k3qQnRrP');
    }

    public function testGenSalt()
    {
        global $passwordHash;

        $this->assertEquals($passwordHash->gensalt_private('password'), '$P$Bk3qQnRrP');
    }

    public function testCrypt()
    {
        global $passwordHash;

        $this->assertEquals($passwordHash->crypt_private('password', null), '*0');
    }

    public function testGenSaltExtended()
    {
        global $passwordHash;

        $this->assertEquals($passwordHash->gensalt_extended('password'), '_zzD.k3qQ');
    }

    public function testGenSaltBlowfish()
    {
        global $passwordHash;

        $this->assertEquals($passwordHash->gensalt_blowfish('passwordpassword'), '$2a$08$aEDxa1btakPuWVLxb07wX.');
    }

    public function testHashPassword()
    {
        global $passwordHash;

        $this->assertEquals(strlen($passwordHash->HashPassword('password')), 34);
    }

    public function testCheckPassword()
    {
        global $passwordHash;
        $password = 'password';

        $this->assertTrue($passwordHash->CheckPassword($password, $passwordHash->HashPassword($password)));
        $this->assertFalse($passwordHash->CheckPassword($password . ',', $passwordHash->HashPassword($password)));
    }
}
