<?php

namespace App\Entity;

use App\Repository\DietRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DietRepository::class)]
class Diet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'diets')]
    private Collection $diet_has_menu;

    public function __construct()
    {
        $this->diet_has_menu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getDietHasMenu(): Collection
    {
        return $this->diet_has_menu;
    }

    public function addDietHasMenu(Menu $dietHasMenu): self
    {
        if (!$this->diet_has_menu->contains($dietHasMenu)) {
            $this->diet_has_menu->add($dietHasMenu);
        }

        return $this;
    }

    public function removeDietHasMenu(Menu $dietHasMenu): self
    {
        $this->diet_has_menu->removeElement($dietHasMenu);

        return $this;
    }
}
