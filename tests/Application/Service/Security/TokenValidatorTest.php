<?php

namespace App\Tests\Application\Service\Security;

use App\Application\Service\Security\InvalidTokenException;
use App\Application\Service\Security\TokenValidator;
use PHPUnit\Framework\TestCase;

class TokenValidatorTest extends TestCase
{
    protected $secret;

    public function setUp()
    {
        $this->secret = '12345';
    }

    public function testTokenIsValid()
    {
        $validToken = '12345';

        $validator = new TokenValidator($this->secret);
        $validator->validate($validToken);

        $this->addToAssertionCount(1);
    }

    public function testTokenIsInvalid()
    {
        $invalidToken = '00000';

        $this->expectException(InvalidTokenException::class);

        $validator = new TokenValidator($this->secret);
        $validator->validate($invalidToken);
    }

    public function testTokenIsEmpty()
    {
        $this->expectException(InvalidTokenException::class);

        $validator = new TokenValidator($this->secret);
        $validator->validate(null);
    }
}
