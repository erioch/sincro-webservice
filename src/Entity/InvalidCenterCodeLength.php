<?php

namespace App\Entity;

class InvalidCenterCodeLength extends \Exception
{
    const MESSAGE = 'A center code must have a lenght of %s chars';

    /**
     * @param $length
     *
     * @return InvalidCenterCodeLength
     */
    public static function fromLength($length)
    {
        return new self(
            sprintf(self::MESSAGE, $length)
        );
    }
}
