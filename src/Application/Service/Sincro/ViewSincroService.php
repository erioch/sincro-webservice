<?php

namespace App\Application\Service\Sincro;

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
            $request->sincroId()
        );
    }
}
