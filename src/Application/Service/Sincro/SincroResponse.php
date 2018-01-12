<?php

namespace App\Application\Service\Sincro;

use App\Entity\Sincro;

class SincroResponse
{
    private $uploadsDir;
    private $downloadBaseUrl;

    public function __construct($uploadsDir, $downloadBaseUrl)
    {
        $this->uploadsDir = $uploadsDir;
        $this->downloadBaseUrl = $downloadBaseUrl;
    }

    /**
     * @param Sincro[] $sincros
     *
     * @return array
     */
    public function fromArray(array $sincros)
    {
        $data = [];

        foreach ($sincros as $sincro) {
            $data[] = $this->toArray($sincro);
        }

        return $data;
    }

    /**
     * @param Sincro $sincro
     *
     * @return array
     */
    public function toArray(Sincro $sincro)
    {
        return [
            'id' => $sincro->id(),
            'origin' => $sincro->origin(),
            'destiny' => $sincro->destiny(),
            'post' => $sincro->postDate()->format('Y-m-d H:i:s'),
            'request' => $sincro->requestDate() ? $sincro->requestDate()->format('Y-m-d H:i:s') : null,
            'sync' => $sincro->syncDate() ? $sincro->syncDate()->format('Y-m-d H:i:s') : null,
            'file' => $sincro->filename(),
            'path' => $this->uploadsDir.'/'.$sincro->filename(),
            'link' => $this->downloadBaseUrl.'/'.$sincro->filename(),
        ];
    }
}
