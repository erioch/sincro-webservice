<?php

namespace App\Application\Service\Sincro;

use App\Application\Service\ApplicationService;
use App\Repository\SincroRepository;

abstract class SincroService implements ApplicationService
{
    protected $sincroRepository;

    public function __construct(SincroRepository $sincroRepository)
    {
        $this->sincroRepository = $sincroRepository;
    }
}
