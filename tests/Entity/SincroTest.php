<?php

namespace App\Tests\Entity;

use App\Entity\Sincro;
use PHPUnit\Framework\TestCase;

class SincroTest extends TestCase
{
    public function testMakePostReturnsSincroObject()
    {
        $sincro = Sincro::makePost(
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
            'ABC',
            'XYZ',
            'a_file.zip'
        );

        $this->assertInstanceOf(\DateTimeImmutable::class, $sincro->postDate());
    }

    public function testNewSincroHasNoRequestAndSyncDate()
    {
        $sincro = Sincro::makePost(
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

        Sincro::makePost(null, 'XYZ', 'a_file.zip');
    }

    public function testDestinyIsNotEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);

        Sincro::makePost('ABC', null, 'a_file.zip');
    }

    public function testFilenameIsNotEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);

        Sincro::makePost('ABC', 'XYZ', null);
    }

    public function testOriginWithShortLenghtIsInvalid()
    {
        $origin = 'AB';
        $destiny = 'XYZ';

        $this->expectExceptionMessage(sprintf(
            'A origin center must have a lenght of %d chars',
            Sincro::ORIGIN_MAX_LENGTH
        ));

        Sincro::makePost(
            $origin,
            $destiny,
            'a_file.zip'
        );
    }

    public function testOriginWithLongLenghtIsInvalid()
    {
        $origin = 'ABCD';
        $destiny = 'XYZ';

        $this->expectExceptionMessage(sprintf(
            'A origin center must have a lenght of %d chars',
            Sincro::ORIGIN_MAX_LENGTH
        ));

        Sincro::makePost(
            $origin,
            $destiny,
            'a_file.zip'
        );
    }

    public function testDestinyWithShortLenghtIsInvalid()
    {
        $origin = 'ABC';
        $destiny = 'XY';

        $this->expectExceptionMessage(sprintf(
            'A destiny center must have a lenght of %d chars',
            Sincro::ORIGIN_MAX_LENGTH
        ));

        Sincro::makePost(
            $origin,
            $destiny,
            'a_file.zip'
        );
    }

    public function testDestinyWithLongLenghtIsInvalid()
    {
        $origin = 'ABC';
        $destiny = 'XYZ0';

        $this->expectExceptionMessage(sprintf(
            'A destiny center must have a lenght of %d chars',
            Sincro::ORIGIN_MAX_LENGTH
        ));

        Sincro::makePost(
            $origin,
            $destiny,
            'a_file.zip'
        );
    }

    public function testRequestUpdatesRequestDate()
    {
        $sincro = Sincro::makePost(
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
