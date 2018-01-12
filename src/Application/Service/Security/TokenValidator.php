<?php

namespace App\Application\Service\Security;

class TokenValidator
{
    /**
     * @var string
     */
    private $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param string $token
     *
     * @throws InvalidTokenException
     */
    public function validate($token)
    {
        $token = trim($token);

        if (!$token) {
            throw InvalidTokenException::fromEmptyToken();
        }

        if ($token !== $this->secret) {
            throw InvalidTokenException::fromInvalidToken($token);
        }
    }
}
