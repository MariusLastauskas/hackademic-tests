<?php

namespace Test;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PasswordHash;

/**
 * Class GeneratedPasswordHashTest.
 *
 * @covers \PasswordHash
 */
class GeneratedPasswordHashTest extends TestCase
{
    /**
     * @var PasswordHash $passwordHash An instance of "PasswordHash" to test.
     */
    private $passwordHash;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        /** @todo Maybe add some arguments to this constructor */
        $this->passwordHash = new PasswordHash(1, true);
    }

    /**
     * @covers \PasswordHash::PasswordHash
     */
    public function testPasswordHash()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }

    /**
     * @covers \PasswordHash::get_random_bytes
     */
    public function testGetrandombytes()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }

    /**
     * @covers \PasswordHash::encode64
     */
    public function testEncode64()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }

    /**
     * @covers \PasswordHash::gensalt_private
     */
    public function testGensaltprivate()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }

    /**
     * @covers \PasswordHash::crypt_private
     */
    public function testCryptprivate()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }

    /**
     * @covers \PasswordHash::gensalt_extended
     */
    public function testGensaltextended()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }

    /**
     * @covers \PasswordHash::gensalt_blowfish
     */
    public function testGensaltblowfish()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }

    /**
     * @covers \PasswordHash::HashPassword
     */
    public function testHashPassword()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }

    /**
     * @covers \PasswordHash::CheckPassword
     */
    public function testCheckPassword()
    {
        /** @todo Complete this unit test method. */
        $this->markTestIncomplete();
    }
}
