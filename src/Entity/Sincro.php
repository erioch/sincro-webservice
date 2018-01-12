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
     * @ORM\Column(type="string", nullable=true)
     */
    private $filename;

    /**
     * Sincro constructor.
     *
     * @param $origin
     * @param $destiny
     * @param $filename
     */
    private function __construct($origin, $destiny, $filename)
    {
        $this->setOrigin($origin);
        $this->setDestiny($destiny);
        $this->setFile($filename);

        $this->postDate = new \DateTimeImmutable();
    }

    /**
     * @param string $origin
     */
    public function setOrigin($origin)
    {
        $origin = trim($origin);
        if (!$origin) {
            throw new \InvalidArgumentException('Origin center can not be null!');
        }

        $this->origin = $origin;
    }

    /**
     * @param string $destiny
     */
    public function setDestiny($destiny)
    {
        $destiny = trim($destiny);
        if (!$destiny) {
            throw new \InvalidArgumentException('Destiny center can not be null!');
        }

        $this->destiny = $destiny;
    }

    /**
     * @param $filename
     */
    public function setFile($filename)
    {
        $filename = trim($filename);
        if (!$filename) {
            throw new \InvalidArgumentException('DB file is empty!');
        }

        $this->filename = $filename;
    }

    /**
     * @param $origin
     * @param $destiny
     * @param $filename
     *
     * @return Sincro
     */
    public static function makePost($origin, $destiny, $filename)
    {
        return new self($origin, $destiny, $filename);
    }

    public function request()
    {
        $this->requestDate = new \DateTimeImmutable();
    }

    public function sync()
    {
        $this->syncDate = new \DateTimeImmutable();
    }

    public function id()
    {
        return $this->id;
    }

    public function origin()
    {
        return $this->origin;
    }

    public function destiny()
    {
        return $this->destiny;
    }

    public function postDate()
    {
        return $this->postDate;
    }

    public function requestDate()
    {
        return $this->requestDate;
    }

    public function syncDate()
    {
        return $this->syncDate;
    }

    public function filename()
    {
        return $this->filename;
    }
}
