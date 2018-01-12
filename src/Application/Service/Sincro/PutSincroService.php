<?php

namespace App\Application\Service\Sincro;

class PutSincroService extends SincroService
{
    /**
     * @param PutSincroRequest $request
     */
    public function execute($request = null)
    {
        $sincro = $this->sincroRepository->ofIdOrFail(
            $request->sincroId()
        );

        if (!$sincro->syncDate()) {
            $sincro->sync();
            $this->sincroRepository->flush();
        }
    }
}
