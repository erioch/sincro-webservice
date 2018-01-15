<?php

namespace App\Tests\Application\Service\Sincro;

use App\Application\Service\Sincro\PostSincroRequest;
use App\Application\Service\Sincro\PostSincroService;
use App\Entity\Sincro;
use App\Persistance\InMemory\InMemorySincroRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostSincroServiceTest extends TestCase
{
    /**
     * @var InMemorySincroRepository
     */
    protected $repository;

    /**
     * @var PostSincroService
     */
    protected $service;

    public function setUp()
    {
        $this->repository = new InMemorySincroRepository();
        $this->service = new PostSincroService($this->repository, 'uploads');
    }

    private function executeService()
    {
        $uploadedFile = $this->createMock(UploadedFile::class);

        return $this->service->execute(
            new PostSincroRequest(
                'ABC',
                'XYZ',
                $uploadedFile
            )
        );
    }

    public function testPostServiceReturnsAValidNewSincroObject()
    {
        $sincro = $this->executeService();

        $this->assertInstanceOf(Sincro::class, $sincro);
        $this->assertInstanceOf(\DateTimeImmutable::class, $sincro->postDate());
        $this->assertNull($sincro->requestDate());
        $this->assertNull($sincro->syncDate());
    }
}
