<?php

namespace App\Application\Service\Sincro;

use App\Entity\Sincro;

class PostSincroService extends SincroService
{
    /**
     * @param PostSincroRequest $request
     *
     * @return Sincro
     */
    public function execute($request = null)
    {
        $sincro = Sincro::makePost(
            $request->origin(),
            $request->destiny(),
            $request->file()
        );

        $this->sincroRepository->add($sincro);

        return $sincro;
    }
}
