<?php

namespace App\Tests\Repository;

use App\Entity\Sincro;
use App\Entity\SincroId;
use App\Entity\SincroNotFoundException;
use App\Persistance\InMemory\InMemorySincroRepository;
use PHPUnit\Framework\TestCase;

class DoctrineSincroRepositoryTest extends TestCase
{
    private $origin = 'ABC';
    private $destiny = 'XYZ';

    /**
     * @var InMemorySincroRepository
     */
    private $sincroRepository;

    public function setUp()
    {
        $this->sincroRepository = new InMemorySincroRepository();
    }

    private function makeSincro()
    {
        return Sincro::makePost(
            $this->sincroRepository->nextIdentity(),
            $this->origin,
            $this->destiny,
            'file.zip'
        );
    }

    public function testSincroExists()
    {
        $sincro = $this->makeSincro();
        $this->sincroRepository->add($sincro);

        $this->assertNotNull(
            $this->sincroRepository->ofIdOrFail($sincro->id())
        );
    }

    public function testSincroDoesNotExists()
    {
        $this->expectException(SincroNotFoundException::class);
        $this->sincroRepository->ofIdOrFail(new SincroId());
    }

    public function testRemoveShouldRemoveASincro()
    {
        $sincro = $this->makeSincro();
        $this->sincroRepository->add($sincro);

        $this->sincroRepository->remove($sincro);
        $this->assertEquals(0, $this->sincroRepository->size());
    }

    public function testFetchSincrosPendingToSync()
    {
        $sincro1 = $this->makeSincro();
        $sincro2 = $this->makeSincro();
        $sincro3 = $this->makeSincro();
        $sincro4 = $this->makeSincro();

        $sincro1->sync();
        $sincro2->sync();

        $this->sincroRepository->add($sincro1);
        $this->sincroRepository->add($sincro2);
        $this->sincroRepository->add($sincro3);
        $this->sincroRepository->add($sincro4);

        $toSync = $this->sincroRepository->ofDestinyPendingToSync($this->destiny);
        $this->assertEquals(2, count($toSync));
    }

    public function testFetchSincrosRequestedPendingToSync()
    {
        $sincro1 = $this->makeSincro();
        $sincro2 = $this->makeSincro();
        $sincro3 = $this->makeSincro();
        $sincro4 = $this->makeSincro();

        $sincro1->request();
        $sincro2->request();
        $sincro3->request();

        $sincro1->sync();
        $sincro2->sync();

        $this->sincroRepository->add($sincro1);
        $this->sincroRepository->add($sincro2);
        $this->sincroRepository->add($sincro3);
        $this->sincroRepository->add($sincro4);

        $toSync = $this->sincroRepository->requestedPendingToSync();
        $this->assertEquals(1, count($toSync));
    }
}
