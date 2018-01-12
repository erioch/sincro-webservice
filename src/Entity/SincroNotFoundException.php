<?php

namespace App\Entity;

class SincroNotFoundException extends \Exception
{
    const MESSAGE = 'Sincro with id [%s] was not found';

    /**
     * @param $sincroId
     *
     * @return SincroNotFoundException
     */
    public static function fromId($sincroId)
    {
        return new self(
            sprintf(self::MESSAGE, $sincroId)
        );
    }
}
