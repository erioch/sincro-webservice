<?php

namespace App\Tests\Application\Service\Sincro;

use App\Application\Service\Sincro\GetSincroRequest;
use App\Application\Service\Sincro\GetSincroService;
use App\Entity\Sincro;
use App\Persistance\InMemory\InMemorySincroRepository;
use PHPUnit\Framework\TestCase;

class GetSincroServiceTest extends TestCase
{
    /**
     * @var InMemorySincroRepository
     */
    protected $repository;

    /**
     * @var GetSincroService
     */
    protected $service;

    public function setUp()
    {
        $this->repository = new InMemorySincroRepository();
        $this->service = new GetSincroService($this->repository, 'uploads');

        $this->addSincros();
    }

    private function addSincros()
    {
        $destinies = [
            '456',
            '456',
            '789',
            'ABC',
        ];

        foreach ($destinies as $destiny) {
            $this->repository->add(
                $this->createSincro('123', $destiny)
            );
        }
    }

    private function createSincro($origin, $destiny)
    {
        return Sincro::makePost(
            $this->repository->nextIdentity(),
            $origin,
            $destiny,
            'file.zip'
        );
    }

    public function testRequestSincrosOfDestiny()
    {
        $requested = $this->service->execute(
            new GetSincroRequest('456')
        );

        $this->assertEquals(2, count($requested));

        foreach ($requested as $sincro) {
            $this->assertNotNull($sincro->requestDate());
        }
    }
}
