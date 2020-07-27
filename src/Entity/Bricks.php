<?php

namespace App\Entity;

use App\Repository\BricksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BricksRepository::class)
 */
class Bricks
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $stored_date;

    /**
     * Bricks constructor.
     */
    public function __construct()
    {
        $this->stored_date= new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStoredDate(): ?\DateTimeInterface
    {
        return $this->stored_date;
    }

    public function setStoredDate(\DateTimeInterface $stored_date): self
    {
        $this->stored_date = $stored_date;

        return $this;
    }

    public function __toString() {
        return (string) $this->amount;
    }
}
