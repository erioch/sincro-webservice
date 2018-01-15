<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;

class SincroId
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id = null)
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param SincroId $sincroId
     *
     * @return bool
     */
    public function equals(SincroId $sincroId): bool
    {
        return $this->id() === $sincroId->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
