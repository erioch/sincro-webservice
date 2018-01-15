<?php

namespace App\Application\Service\Sincro;

use App\Entity\SincroId;

class ViewSincroService extends SincroService
{
    /**
     * @param ViewSincroRequest $request
     *
     * @return \App\Entity\Sincro
     */
    public function execute($request = null)
    {
        return $this->sincroRepository->ofIdOrFail(
            new SincroId($request->sincroId())
        );
    }
}
