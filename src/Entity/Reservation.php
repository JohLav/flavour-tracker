<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetime = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $payment_mode = null;

    #[ORM\Column]
    private ?int $adult_nb = null;

    #[ORM\Column]
    private ?int $kid_nb = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $service = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getPaymentMode(): ?string
    {
        return $this->payment_mode;
    }

    public function setPaymentMode(?string $payment_mode): self
    {
        $this->payment_mode = $payment_mode;

        return $this;
    }

    public function getAdultNb(): ?int
    {
        return $this->adult_nb;
    }

    public function setAdultNb(int $adult_nb): self
    {
        $this->adult_nb = $adult_nb;

        return $this;
    }

    public function getKidNb(): ?int
    {
        return $this->kid_nb;
    }

    public function setKidNb(int $kid_nb): self
    {
        $this->kid_nb = $kid_nb;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
