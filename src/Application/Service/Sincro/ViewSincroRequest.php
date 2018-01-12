<?php

namespace App\Application\Service\Sincro;

class ViewSincroRequest
{
    private $sincroId;

    public function __construct($sincroId)
    {
        $this->sincroId = $sincroId;
    }

    public function sincroId()
    {
        return $this->sincroId;
    }
}
