<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use Utils;

class UtilsTest extends TestCase {

    function emailTestCasesProvider() {
        return [
                'validEmailTestCases' => [
                    'email@domain.com', 
                    'firstname.lastname@domain.com', 
                    'email@subdomain.domain.com',
                    'firstname+lastname@domain.com',
                    '1234567890@domain.com',
                    'email@domain-one.com',
                    '_______@domain.com',
                    'email@domain.name',
                    'email@domain.co.jp',
                    'firstname-lastname@domain.com'
                ],        
                
                'validStrangeEmailTestCases' => [
                    'email@123.123.123.123',
                    'email@[123.123.123.123]',
                    '"email"@domain.com'
                ],
            
                
                'invalitEmailTestCases' => [
                    'plainaddress',
                    '#@%^%#$@#$@#.com',
                    '@domain.com',
                    'Joe Smith <email@domain.com>',
                    'email.domain.com',
                    'email@domain@domain.com',
                    '.email@domain.com',
                    'email.@domain.com',
                    'あいうえお@domain.com',
                    'email@domain.com (Joe Smith)',
                    'email@domain',
                    'email@-domain.com',
                    'email@111.222.333.44444',
                    'email@domain..com'
                ],
            ];
    }

    public function testConstantsDefinition() {
        Utils::defineConstants();

        $this->assertTrue(defined('HACKADEMIC_PATH'));
        $this->assertEquals(HACKADEMIC_PATH, 'D:/Programs/xampp5/htdocs/hackademic-tests/');
        $this->assertTrue(defined('GLOBAL_CLASS_ID'));
        $this->assertEquals(GLOBAL_CLASS_ID, 1);
        $this->assertTrue(defined('DEFAULT_RULES_ID'));
        $this->assertEquals(DEFAULT_RULES_ID, 1);
        $this->assertTrue(defined('NO_RESULTS'));
        $this->assertEquals(NO_RESULTS, false);
        $this->assertTrue(defined('MICROSECS_IN_MINUTE'));
        $this->assertEquals(MICROSECS_IN_MINUTE, 60);
    }
    
    public function testValidEmailValidation() {
        foreach ($this->emailTestCasesProvider()['validEmailTestCases'] as $testCase) {
            $this->assertEquals(Utils::validateEmail($testCase), 1);
        }
    }

    // public function testValidStrangeEmailValidation() {
    //     foreach ($this->emailTestCasesProvider()['validStrangeEmailTestCases'] as $testCase) {
    //         $this->assertEquals(Utils::validateEmail($testCase), 1);
    //     }
    // }

    public function testInvalidEmailValidation() {
        foreach ($this->emailTestCasesProvider()['invalitEmailTestCases'] as $testCase) {
            $this->assertEquals(Utils::validateEmail($testCase), 0);
        }
    }

    public function testGetUtil() {
        $util = Utils::getPassUtil();

        $this->assertTrue($util->portable_hashes);

        $random = (float)$util->random_state;

        $this->assertEquals($random >= 0 && $random <= 1, true);
    }

    public function testHash() {
        $password = 'myawesomepassword';

        $this->assertEquals(strlen(Utils::hash($password)), 34);
    }

    public function testPasswordCheck() {
        $password = 'myawesomepassword';
        $hash = Utils::hash($password);

        $this->assertTrue(Utils::check($password, $hash));
        $this->assertFalse(Utils::check('wrongPass', $hash));
    }

    public function testSanitization() {
        $input = "<a href='test'>Test</a>";
        $sanitized_input = "&lt;a href='test'&gt;Test&lt;/a&gt;";
        
        $this->assertEquals(Utils::sanitizeInput($input), $sanitized_input);
    }
}