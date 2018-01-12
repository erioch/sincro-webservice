<?php

namespace App\Tests\Application\Service\Sincro;

use App\Application\Service\Sincro\PostSincroRequest;
use App\Application\Service\Sincro\PostSincroService;
use App\Entity\Sincro;
use App\Repository\SincroRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostSincroServiceTest extends TestCase
{
    protected $repository;
    protected $request;
    protected $service;

    public function setUp()
    {
        $this->repository = $this->createMock(SincroRepository::class);

        $uploadedFile = $this->createMock(UploadedFile::class);
        $this->request = new PostSincroRequest(
            'ABC',
            'XYZ',
            $uploadedFile
        );

        $this->service = new PostSincroService($this->repository, 'uploads');
    }

    public function testPostServiceReturnsAValidNewSincroObject()
    {
        $result = $this->service->execute($this->request);

        $this->assertInstanceOf(Sincro::class, $result);
        $this->assertInstanceOf(\DateTimeImmutable::class, $result->postDate());
        $this->assertNull($result->requestDate());
        $this->assertNull($result->syncDate());
    }
}
