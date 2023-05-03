<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $department = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $simpleName = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $realName = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $soundexName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zipCode = null;

    #[ORM\Column(length: 3)]
    private ?string $city = null;

    #[ORM\Column(length: 5)]
    private ?string $commonCode = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $district = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $canton = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitudeDeg = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitudeDeg = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $longitudeGrd = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $latitudeGrd = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $longitudeDms = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $latitudeDms = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Restaurant $restaurant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSimpleName(): ?string
    {
        return $this->simpleName;
    }

    public function setSimpleName(?string $simpleName): self
    {
        $this->simpleName = $simpleName;

        return $this;
    }

    public function getRealName(): ?string
    {
        return $this->realName;
    }

    public function setRealName(?string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    public function getSoundexName(): ?string
    {
        return $this->soundexName;
    }

    public function setSoundexName(?string $soundexName): self
    {
        $this->soundexName = $soundexName;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCommonCode(): ?string
    {
        return $this->commonCode;
    }

    public function setCommonCode(string $commonCode): self
    {
        $this->commonCode = $commonCode;

        return $this;
    }

    public function getDistrict(): ?int
    {
        return $this->district;
    }

    public function setDistrict(?int $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getCanton(): ?string
    {
        return $this->canton;
    }

    public function setCanton(?string $canton): self
    {
        $this->canton = $canton;

        return $this;
    }

    public function getLongitudeDeg(): ?float
    {
        return $this->longitudeDeg;
    }

    public function setLongitudeDeg(?float $longitude): self
    {
        $this->longitudeDeg = $longitude;

        return $this;
    }

    public function getLatitudeDeg(): ?float
    {
        return $this->latitudeDeg;
    }

    public function setLatitudeDeg(?float $latitude): self
    {
        $this->latitudeDeg = $latitude;

        return $this;
    }

    public function getLongitudeGrd(): ?string
    {
        return $this->longitudeGrd;
    }

    public function setLongitudeGrd(?string $longitudeGrd): self
    {
        $this->longitudeGrd = $longitudeGrd;

        return $this;
    }

    public function getLatitudeGrd(): ?string
    {
        return $this->latitudeGrd;
    }

    public function setLatitudeGrd(?string $latitudeGrd): self
    {
        $this->latitudeGrd = $latitudeGrd;

        return $this;
    }

    public function getLongitudeDms(): ?string
    {
        return $this->longitudeDms;
    }

    public function setLongitudeDms(?string $longitudeDms): self
    {
        $this->longitudeDms = $longitudeDms;

        return $this;
    }

    public function getLatitudeDms(): ?string
    {
        return $this->latitudeDms;
    }

    public function setLatitudeDms(?string $latitudeDms): self
    {
        $this->latitudeDms = $latitudeDms;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }
}
