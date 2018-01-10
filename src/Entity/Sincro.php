<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Sincro
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    private $origin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    private $destiny;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $postDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $requestDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $syncDate;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $dbFile;

    /**
     * Sincro constructor.
     *
     * @param $origin
     * @param $destiny
     * @param $dbFile
     */
    private function __construct($origin, $destiny, $dbFile)
    {
        $this->origin = $origin;
        $this->destiny = $destiny;
        $this->setFile($dbFile);

        $this->postDate = new \DateTimeImmutable();
    }

    /**
     * @param $dbFile
     */
    public function setFile($dbFile)
    {
        if (!$dbFile) {
            throw new \InvalidArgumentException('DB file is empty!');
        }

        $this->dbFile = base64_encode(stream_get_contents($dbFile));
    }

    /**
     * @return bool|string
     */
    public function readFile()
    {
        return base64_decode($this->dbFile);
    }

    /**
     * @param $origin
     * @param $destiny
     * @param $dbFile
     *
     * @return Sincro
     */
    public static function makePost($origin, $destiny, $dbFile)
    {
        return new self($origin, $destiny, $dbFile);
    }

    public function request()
    {
        $this->requestDate = new \DateTimeImmutable();
    }

    public function sync()
    {
        $this->syncDate = new \DateTimeImmutable();
    }
}
