<?php

namespace App\Repository;

use App\Entity\Sincro;
use Doctrine\ORM\EntityManagerInterface;

class SincroRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Sincro::class);
    }

    public function ofDestiny($destiny)
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

    public function flush()
    {
        $this->em->flush();
    }

    public function add(Sincro $sincro)
    {
        $this->em->persist($sincro);
        $this->em->flush();
    }

    public function remove(Sincro $sincro)
    {
        $this->em->remove($sincro);
        $this->em->flush();
    }
}
