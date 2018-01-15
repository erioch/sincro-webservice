<?php

namespace App\Tests\Application\Service\Sincro;

use App\Application\Service\Sincro\PutSincroRequest;
use App\Application\Service\Sincro\PutSincroService;
use App\Entity\Sincro;
use App\Persistance\InMemory\InMemorySincroRepository;
use PHPUnit\Framework\TestCase;

class PutSincroServiceTest extends TestCase
{
    /**
     * @var InMemorySincroRepository
     */
    protected $repository;

    /**
     * @var PutSincroService
     */
    protected $service;

    public function setUp()
    {
        $this->repository = new InMemorySincroRepository();
        $this->service = new PutSincroService($this->repository, 'uploads');
    }

    public function testRequestedSincroIsSync()
    {
        $sincro = Sincro::makePost(
            $this->repository->nextIdentity(),
            '123',
            '456',
            'file.zip'
        );

        $this->repository->add($sincro);
        $sincro->request();

        $this->service->execute(
            new PutSincroRequest($sincro->id()->id())
        );

        $result = $this->repository->ofIdOrFail($sincro->id());
        $this->assertNotNull($result->syncDate());
    }

    public function testNoRequestedSincroCanNotBeSync()
    {
        $sincro = Sincro::makePost(
            $this->repository->nextIdentity(),
            '123',
            '456',
            'file.zip'
        );

        $this->repository->add($sincro);

        $this->service->execute(
            new PutSincroRequest($sincro->id()->id())
        );

        $result = $this->repository->ofIdOrFail($sincro->id());
        $this->assertNull($result->syncDate());
    }
}
