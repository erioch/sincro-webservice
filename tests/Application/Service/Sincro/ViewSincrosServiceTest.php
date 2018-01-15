<?php

namespace App\Tests\Application\Service\Sincro;

use App\Application\Service\Sincro\ViewSincrosService;
use App\Entity\Sincro;
use App\Persistance\InMemory\InMemorySincroRepository;
use PHPUnit\Framework\TestCase;

class ViewSincrosServiceTest extends TestCase
{
    /**
     * @var InMemorySincroRepository
     */
    protected $repository;

    /**
     * @var ViewSincrosService
     */
    protected $service;

    public function setUp()
    {
        $this->repository = new InMemorySincroRepository();
        $this->service = new ViewSincrosService($this->repository, 'uploads');
    }

    private function makeSincro()
    {
        return Sincro::makePost(
            $this->repository->nextIdentity(),
            '123',
            '456',
            'file.zip'
        );
    }

    public function testReturnsOnlyRequestedPendingToSync()
    {
        $sincro1 = $this->makeSincro();
        $sincro2 = $this->makeSincro();
        $sincro3 = $this->makeSincro();
        $sincro4 = $this->makeSincro();
        $sincro5 = $this->makeSincro();

        $this->repository->addAll([
            $sincro1,
            $sincro2,
            $sincro3,
            $sincro4,
            $sincro5,
        ]);

        $sincro1->request();
        $sincro2->request();
        $sincro3->request();
        $sincro4->request();

        $sincro1->sync();
        $sincro4->sync();
        $sincro5->sync();  // This one sould not count as a valid result

        $result = $this->service->execute();
        $this->assertEquals(2, count($result));
    }
}
