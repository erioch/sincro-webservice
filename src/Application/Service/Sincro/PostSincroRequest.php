<?php

namespace App\Application\Service\Sincro;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostSincroRequest
{
    private $origin;
    private $destiny;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @param string       $origin
     * @param string       $destiny
     * @param UploadedFile $file
     */
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

    /**
     * @return UploadedFile
     */
    public function uploadedFile()
    {
        return $this->file;
    }
}
