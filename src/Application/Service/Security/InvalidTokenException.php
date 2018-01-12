<?php

namespace App\Application\Service\Security;

class InvalidTokenException extends \Exception
{
    public static function fromEmptyToken()
    {
        return new self(
            'You must provide a valid security token, none given'
        );
    }

    public static function fromInvalidToken($token)
    {
        return new self(sprintf(
            'The received security token "%s" is not valid. You must provide a valid token',
            $token
        ));
    }
}
