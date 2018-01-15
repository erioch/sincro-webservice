<?php

namespace App\Tests\Application\Service\Sincro;

use App\Application\Service\Sincro\ViewSincroRequest;
use App\Application\Service\Sincro\ViewSincroService;
use App\Entity\Sincro;
use App\Entity\SincroNotFoundException;
use App\Persistance\InMemory\InMemorySincroRepository;
use PHPUnit\Framework\TestCase;

class ViewSincroServiceTest extends TestCase
{
    /**
     * @var InMemorySincroRepository
     */
    protected $repository;

    /**
     * @var ViewSincroService
     */
    protected $service;

    public function setUp()
    {
        $this->repository = new InMemorySincroRepository();
        $this->service = new ViewSincroService($this->repository, 'uploads');
    }

    public function testSincroExists()
    {
        $sincro = Sincro::makePost(
            $this->repository->nextIdentity(),
            '123',
            '456',
            'file.zip'
        );

        $this->repository->add($sincro);

        $result = $this->service->execute(
            new ViewSincroRequest($sincro->id()->id())
        );

        $this->assertTrue($sincro->id()->equals($result->id()));
    }

    public function testSincroDoesNotExist()
    {
        $this->expectException(SincroNotFoundException::class);
        $this->service->execute(new ViewSincroRequest(null));
    }
}
