<?php

namespace App\Application\Service\Sincro;

class ViewSincrosService extends SincroService
{
    /**
     * @param $request
     *
     * @return \App\Entity\Sincro[]
     */
    public function execute($request = null)
    {
        return $this->sincroRepository->requestedPendingToSync();
    }
}
