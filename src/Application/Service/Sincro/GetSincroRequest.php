<?php

namespace App\Application\Service\Sincro;

class GetSincroRequest
{
    private $destiny;

    public function __construct($destiny)
    {
        $this->destiny = $destiny;
    }

    public function destiny()
    {
        return $this->destiny;
    }
}
