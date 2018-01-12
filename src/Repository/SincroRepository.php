<?php

namespace App\Repository;

use App\Entity\Sincro;

interface SincroRepository
{
    /**
     * @param int $sincroId
     *
     * @return Sincro
     */
    public function ofIdOrFail($sincroId): Sincro;

    /**
     * @param string $destiny
     *
     * @return Sincro[]
     */
    public function ofDestinyPendingToSync($destiny);

    /**
     * @param Sincro $sincro
     */
    public function add(Sincro $sincro);

    /**
     * @param Sincro $sincro
     */
    public function remove(Sincro $sincro);

    public function flush();
}
