<?php

namespace App\Persistance\InMemory;

use App\Entity\Sincro;
use App\Entity\SincroId;
use App\Entity\SincroNotFoundException;
use App\Repository\SincroRepository;

class InMemorySincroRepository implements SincroRepository
{
    /**
     * @var Sincro[]
     */
    private $sincros = [];

    /**
     * {@inheritdoc}
     */
    public function ofIdOrFail(SincroId $sincroId): Sincro
    {
        if (!isset($this->sincros[$sincroId->id()])) {
            throw SincroNotFoundException::fromId($sincroId);
        }

        return $this->sincros[$sincroId->id()];
    }

    /**
     * {@inheritdoc}
     */
    public function ofDestinyPendingToSync($destiny)
    {
        $sincros = [];

        foreach ($this->sincros as $sincro) {
            if ($sincro->destiny() === $destiny && !$sincro->syncDate()) {
                $sincros[] = $sincro;
            }
        }

        return $sincros;
    }

    /**
     * {@inheritdoc}
     */
    public function requestedPendingToSync()
    {
        $sincros = [];

        foreach ($this->sincros as $sincro) {
            if ($sincro->requestDate() && !$sincro->syncDate()) {
                $sincros[] = $sincro;
            }
        }

        return $sincros;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Sincro $sincro)
    {
        $this->sincros[$sincro->id()->id()] = $sincro;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Sincro $sincro)
    {
        unset($this->sincros[$sincro->id()->id()]);
    }

    /**
     * {@inheritdoc}
     */
    public function nextIdentity(): SincroId
    {
        return new SincroId();
    }

    /**
     * @codeCoverageIgnore
     */
    public function flush()
    {
    }

    /**
     * @codeCoverageIgnore
     *
     * @param Sincro[] $sincros
     */
    public function addAll(array $sincros = [])
    {
        foreach ($sincros as $sincro) {
            $this->add($sincro);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function size()
    {
        return count($this->sincros);
    }
}
