<?php

namespace App\Application\Service\Sincro;

use App\Application\Service\ApplicationService;
use App\Repository\SincroRepository;

abstract class SincroService implements ApplicationService
{
    /**
     * @var SincroRepository
     */
    protected $sincroRepository;

    /**
     * @var string
     */
    protected $sincroUploadsDir;

    /**
     * @param SincroRepository $sincroRepository
     * @param string           $uploadsDir
     */
    public function __construct(SincroRepository $sincroRepository, $uploadsDir)
    {
        $this->sincroRepository = $sincroRepository;
        $this->sincroUploadsDir = $uploadsDir;
    }
}
