<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use User;
use Utils;
use HackademicDB;

$userId = [];
class UserTest extends TestCase {

    public function setUp() {
        global $db;
        $db = new HackademicDB();

        User::addUser('testUser1', 'Test User1', 'test.user1@email.com', 'testPass', true, 1, 1);
        $user1 = User::findByUserName('testUser1');
        $user_vals1 = get_object_vars($user1);

        User::addUser('testUser2', 'Test User2', 'test.user2@email.com', 'testPass', true, 1, 1);
        $user2 = User::findByUserName('testUser2');
        $user_vals2 = get_object_vars($user2);

        global $userId;
        $userId = [$user_vals1['id'], $user_vals2['id']];
    }

    public function tearDown() {
        global $userId;
        User::deleteUser($userId[0]);
        User::deleteUser($userId[1]);
    }

    public function testUserCreate() {
        $user = User::findByUserName('testUser1');
        $user_vals = get_object_vars($user);
        
        $this->assertEquals($user_vals['username'], 'testUser1');
    }

//    public function testUserGetMock() {
//        $mock = $this->getMockBuilder(User::class)
//            ->setMethods(['findBySQL'])
//            ->getMock();
//
//        $mock->expects($this->once())
//            ->method('findBySQL');
//
//        $user = new User();
//        $user->getUser(-1);
//    }
//
//    public function testUserGetStub() {
//        global $userId;
//
//        $stub = $this->getMockBuilder(User::class)
//            ->setMethods(['findBySQL'])
//            ->getMock();
//
//        $stub->expects($this->any())
//            ->method('findBySQL')
//            ->will($this->returnValue(false));
//
//        $user = new User();
//
//        $this->assertFalse($user->getUser($userId[0]));
//    }

    public function testFindByUserName() {
        $user = User::findByUserName('testUser1');
        $user_vals = get_object_vars($user);
        
        $this->assertEquals($user_vals['username'], 'testUser1');
        
        $user = User::findByUserName('testUser2');
        $user_vals = get_object_vars($user);
        
        $this->assertEquals($user_vals['username'], 'testUser2');
        
        $user = User::findByUserName('nonExisting');
        
        $this->assertFalse($user);
    }

    public function testGetUserById() {
        global $userId;
        
        $user = User::getUser($userId[0]);
        $user_vals = get_object_vars($user);
        
        $this->assertEquals($user_vals['username'], 'testUser1');
        
        $user = User::getUser($userId[1]);
        $user_vals = get_object_vars($user);
        
        $this->assertEquals($user_vals['username'], 'testUser2');
        
        $user = User::getUser(-1);
        $this->assertFalse($user);
    }

    public function testUpdateToken() {
        global $userId;

        $token = 123456;
        $this->assertTrue(User::addToken('testUser1', $token));
        $this->assertFalse(User::addToken('nonExisting', $token));
        
        $user = User::getUser($userId[0]);
        $user_vals = get_object_vars($user);
        
        $this->assertEquals($user_vals['token'], $token);
    }

    public function testUpdatePassword() {
        global $userId;

        $newPassword = 'newPass';
        $this->assertTrue(User::updatePassword($newPassword, 'testUser1'));
        $this->assertFalse(User::updatePassword($newPassword, 'nonExisting'));
        
        $user = User::getUser($userId[0]);
        $user_vals = get_object_vars($user);

        $this->assertTrue(Utils::check($newPassword, $user_vals['password']));
    }

    public function testUpdateLastVisit() {
        global $userId;

        $this->assertTrue(User::updateLastVisit('testUser1'));
        $this->assertFalse(User::updateLastVisit('nonExisting'));

        $user = User::getUser($userId[0]);
        $user_vals = get_object_vars($user);

        $this->assertTrue($user_vals['last_visit'] != NULL);
    }

    public function testGetNumberOfUsers() {
        global $userId;

        $this->assertTrue(User::getNumberOfUsers() >= 2);

        $this->assertTrue(User::getNumberOfUsers('testUser', 'username') == 2);

        $this->assertTrue(User::getNumberOfUsers('Test User', 'full_name') == 2);

        $this->assertTrue(User::getNumberOfUsers('test.user', 'email') == 2);
    }

    public function testGetNUsers() {
        global $userId;

        $this->assertTrue(count(User::getNUsers(0, 2)) == 2);

        $this->assertTrue(count(User::getNUsers(0, 1)) == 1);
        
        $this->assertTrue(count(User::getNUsers(0, 0)) == 0);

        $this->assertTrue(count(User::getNUsers(9999999999999, 999)) == 0);

        $this->assertTrue(count(User::getNUsers(0, 10, 'testUser', 'username')) == 2);

        $this->assertTrue(count(User::getNUsers(1, 10, 'testUser', 'username')) == 1);

        $this->assertTrue(count(User::getNUsers(2, 10, 'testUser', 'username')) == 0);

        $this->assertTrue(count(User::getNUsers(0, 10, 'Test User', 'full_name')) == 2);

        $this->assertTrue(count(User::getNUsers(1, 10, 'Test User', 'full_name')) == 1);

        $this->assertTrue(count(User::getNUsers(2, 10, 'Test User', 'full_name')) == 0);

        $this->assertTrue(count(User::getNUsers(0, 10, 'test.user', 'email')) == 2);

        $this->assertTrue(count(User::getNUsers(1, 10, 'test.user', 'email')) == 1);

        $this->assertTrue(count(User::getNUsers(2, 10, 'test.user', 'email')) == 0);
    }

    public function testIsUserActive() {        
        $this->assertTrue(User::isUserActivated('testUser1'));
    }

    public function testDoesUserExist() {
        global $userId;

        $this->assertTrue(User::doesUserExist('testUser1'));
        $this->assertTrue(User::doesUserExist('testUser2'));
        $this->assertFalse(User::doesUserExist('nonExisting'));
    }

    public function testUpdateUser() {
        global $userId;

        $newUsername = 'newUsername';
        $newFullName = 'new full name';
        $newEmail = 'new.email@email.com';
        $newPassword = 'newPassword';
        $newIsActivated = 1;
        $newType = 2;

        $this->assertTrue(User::updateUser($userId[0], $newUsername, $newFullName, $newEmail, $newPassword, $newIsActivated, $newType));
        
        $user = User::getUser($userId[0]);
        $user_vals = get_object_vars($user);

        $this->assertEquals($user_vals['username'], $newUsername);
        $this->assertEquals($user_vals['full_name'], $newFullName);
        $this->assertEquals($user_vals['email'], $newEmail);
        $this->assertTrue(Utils::check($newPassword, $user_vals['password']));        
        $this->assertEquals($user_vals['is_activated'], $newIsActivated);  
        $this->assertEquals($user_vals['type'], $newType);

        $this->assertTrue(User::updateUser($userId[1], 'testUser2', $newFullName, $newEmail, '', $newIsActivated, $newType));
        
        $user = User::getUser($userId[1]);
        $user_vals = get_object_vars($user);

        $this->assertEquals($user_vals['username'], 'testUser2');
        $this->assertEquals($user_vals['full_name'], $newFullName);
        $this->assertEquals($user_vals['email'], $newEmail);
        $this->assertTrue(Utils::check('testPass', $user_vals['password']));        
        $this->assertEquals($user_vals['is_activated'], $newIsActivated);  
        $this->assertEquals($user_vals['type'], $newType);

        $this->assertFalse(User::updateUser(-1, 'testUser2', $newFullName, $newEmail, '', $newIsActivated, $newType));
    }

    public function testValidateToken() {
        global $userId;

        $token = 123456;
        $this->assertTrue(User::addToken('testUser1', $token));

        $this->assertTrue(User::ValidateToken('testUser1', $token));
        $this->assertFalse(User::ValidateToken('testUser1', 1));
    }
}