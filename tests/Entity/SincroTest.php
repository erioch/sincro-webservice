<?php

namespace App\Tests\Entity;

use App\Entity\InvalidCenterCodeLength;
use App\Entity\Sincro;
use App\Entity\SincroId;
use PHPUnit\Framework\TestCase;

class SincroTest extends TestCase
{
    public function testMakePostReturnsSincroObject()
    {
        $sincro = Sincro::makePost(
            new SincroId(),
            'ABC',
            'XYZ',
            'a_file.zip'
        );

        $this->assertInstanceOf(Sincro::class, $sincro);
        $this->assertEquals('ABC', $sincro->origin());
        $this->assertEquals('XYZ', $sincro->destiny());
        $this->assertEquals('a_file.zip', $sincro->filename());
    }

    public function testNewSincroHasAPostDate()
    {
        $sincro = Sincro::makePost(
            new SincroId(),
            'ABC',
            'XYZ',
            'a_file.zip'
        );

        $this->assertInstanceOf(\DateTimeImmutable::class, $sincro->postDate());
    }

    public function testNewSincroHasNoRequestAndSyncDate()
    {
        $sincro = Sincro::makePost(
            new SincroId(),
            'ABC',
            'XYZ',
            'a_file.zip'
        );

        $this->assertNull($sincro->requestDate());
        $this->assertNull($sincro->syncDate());
    }

    public function testOriginIsNotEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);

        Sincro::makePost(new SincroId(), null, 'XYZ', 'a_file.zip');
    }

    public function testDestinyIsNotEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);

        Sincro::makePost(new SincroId(), 'ABC', null, 'a_file.zip');
    }

    public function testFilenameIsNotEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);

        Sincro::makePost(new SincroId(), 'ABC', 'XYZ', null);
    }

    public function testOriginWithLongCodeIsInvalid()
    {
        $this->expectException(InvalidCenterCodeLength::class);

        Sincro::makePost(
            new SincroId(),
            'ABCD',
            'XYZ',
            'a_file.zip'
        );
    }

    public function testOriginWithShortCodeIsInvalid()
    {
        $this->expectException(InvalidCenterCodeLength::class);

        Sincro::makePost(
            new SincroId(),
            'AB',
            'XYZ',
            'a_file.zip'
        );
    }

    public function testDestinyWithLongCodeIsInvalid()
    {
        $this->expectException(InvalidCenterCodeLength::class);

        Sincro::makePost(
            new SincroId(),
            'ABC',
            'XYZ0',
            'a_file.zip'
        );
    }

    public function testDestinyWithShortCodeIsInvalid()
    {
        $this->expectException(InvalidCenterCodeLength::class);

        Sincro::makePost(
            new SincroId(),
            'ABC',
            'XY',
            'a_file.zip'
        );
    }

    public function testRequestUpdatesRequestDate()
    {
        $sincro = Sincro::makePost(
            new SincroId(),
            'ABC',
            'XYZ',
            'a_file.zip'
        );

        $sincro->request();

        $this->assertInstanceOf(
            \DateTimeImmutable::class,
            $sincro->requestDate()
        );
    }

    public function testSyncUpdatesSyncDate()
    {
        $sincro = Sincro::makePost(
            new SincroId(),
            'ABC',
            'XYZ',
            'a_file.zip'
        );

        $sincro->sync();

        $this->assertInstanceOf(
            \DateTimeImmutable::class,
            $sincro->syncDate()
        );
    }
}
