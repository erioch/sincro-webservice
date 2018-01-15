<?php

namespace App\Application\Service\Sincro;

use App\Entity\SincroId;

class PutSincroService extends SincroService
{
    /**
     * @param PutSincroRequest $request
     */
    public function execute($request = null)
    {
        $sincro = $this->sincroRepository->ofIdOrFail(
            new SincroId($request->sincroId())
        );

        if ($sincro->requestDate() && !$sincro->syncDate()) {
            $sincro->sync();
            $this->sincroRepository->flush();
        }
    }
}
