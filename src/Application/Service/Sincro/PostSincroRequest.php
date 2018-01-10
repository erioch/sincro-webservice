<?php

namespace App\Application\Service\Sincro;

class PostSincroRequest
{
    private $origin;
    private $destiny;
    private $file;

    public function __construct($origin, $destiny, $file)
    {
        $this->origin = $origin;
        $this->destiny = $destiny;
        $this->file = $file;
    }

    public function origin()
    {
        return $this->origin;
    }

    public function destiny()
    {
        return $this->destiny;
    }

    public function file()
    {
        return $this->file;
    }
}
