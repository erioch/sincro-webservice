<?php

namespace App\Persistance\Doctrine;

use App\Entity\Sincro;
use App\Entity\SincroId;
use App\Entity\SincroNotFoundException;
use App\Repository\SincroRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSincroRepository implements SincroRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param SincroId $sincroId
     *
     * @return Sincro
     *
     * @throws SincroNotFoundException
     */
    public function ofIdOrFail(SincroId $sincroId): Sincro
    {
        $sincro = $this->em->find(
            Sincro::class,
            $sincroId
        );

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
        return $this->em->createQueryBuilder()
            ->select('s')
            ->from('App:Sincro', 's')
            ->where(
                's.destiny = :destiny 
                AND s.syncDate IS NULL'
            )
            ->setParameter('destiny', $destiny)
            ->orderBy('s.postDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Sincro[]
     */
    public function requestedPendingToSync()
    {
        return $this->em->createQueryBuilder()
            ->select('s')
            ->from('App:Sincro', 's')
            ->where(
                's.requestDate IS NOT NULL 
                AND s.syncDate IS NULL'
            )
            ->orderBy('s.postDate', 'ASC')
            ->getQuery()
            ->getResult();
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

    /**
     * @return SincroId
     */
    public function nextIdentity(): SincroId
    {
        return new SincroId();
    }

    public function flush()
    {
        $this->em->flush();
    }
}
