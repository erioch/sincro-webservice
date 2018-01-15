<?php

namespace App\Repository;

use App\Entity\Sincro;
use App\Entity\SincroId;
use App\Entity\SincroNotFoundException;

interface SincroRepository
{
    /**
     * @param SincroId $sincroId
     *
     * @return Sincro
     *
     * @throws SincroNotFoundException
     */
    public function ofIdOrFail(SincroId $sincroId): Sincro;

    /**
     * @param string $destiny
     *
     * @return Sincro[]
     */
    public function ofDestinyPendingToSync($destiny);

    /**
     * @return Sincro[]
     */
    public function requestedPendingToSync();

    /**
     * @param Sincro $sincro
     */
    public function add(Sincro $sincro);

    /**
     * @param Sincro $sincro
     */
    public function remove(Sincro $sincro);

    /**
     * @return SincroId
     */
    public function nextIdentity(): SincroId;
}
