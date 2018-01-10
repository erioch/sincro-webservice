<?php

namespace App\Application\Service;

interface ApplicationService
{
    /**
     * @param $request
     */
    public function execute($request = null);
}
