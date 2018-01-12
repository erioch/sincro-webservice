<?php

namespace App\Repository;

use App\Entity\Sincro;
use App\Entity\SincroNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSincroRepository implements SincroRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Sincro::class);
        $this->em = $em;
    }

    /**
     * @param int $sincroId
     *
     * @return Sincro
     *
     * @throws SincroNotFoundException
     */
    public function ofIdOrFail($sincroId): Sincro
    {
        $sincro = $this->repository->find($sincroId);

        if ($sincro === null) {
            throw SincroNotFoundException::fromId($sincroId);
        }

        return $sincro;
    }

    /**
     * @param string $destiny
     *
     * @return Sincro[]
     */
    public function ofDestinyPendingToSync($destiny)
    {
        return $this->repository->findBy(
            [
                'destiny' => $destiny,
                'syncDate' => null,
            ],
            [
                'postDate' => 'ASC',
            ]
        );
    }

    /**
     * @param Sincro $sincro
     */
    public function add(Sincro $sincro)
    {
        $this->em->persist($sincro);
        $this->em->flush();
    }

    /**
     * @param Sincro $sincro
     */
    public function remove(Sincro $sincro)
    {
        $this->em->remove($sincro);
        $this->em->flush();
    }

    public function flush()
    {
        $this->em->flush();
    }
}
