<?php

namespace App\Application\Service\Sincro;

use App\Entity\Sincro;

class GetSincroService extends SincroService
{
    /**
     * @param GetSincroRequest $request
     *
     * @return array
     */
    public function execute($request = null)
    {
        $pending = $this->sincroRepository->ofDestinyPendingToSync(
            $request->destiny()
        );

        /** @var Sincro $sincro */
        foreach ($pending as $sincro) {
            $sincro->request();
        }

        $this->sincroRepository->flush();

        return $pending;
    }
}
