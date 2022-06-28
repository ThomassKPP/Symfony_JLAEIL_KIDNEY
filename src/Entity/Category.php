<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Rap;

    #[ORM\Column(type: 'string', length: 255)]
    private $Pop;

    #[ORM\Column(type: 'string', length: 255)]
    private $House;

    #[ORM\Column(type: 'string', length: 255)]
    private $Techno;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRap(): ?string
    {
        return $this->Rap;
    }

    public function setRap(string $Rap): self
    {
        $this->Rap = $Rap;

        return $this;
    }

    public function getPop(): ?string
    {
        return $this->Pop;
    }

    public function setPop(string $Pop): self
    {
        $this->Pop = $Pop;

        return $this;
    }

    public function getHouse(): ?string
    {
        return $this->House;
    }

    public function setHouse(string $House): self
    {
        $this->House = $House;

        return $this;
    }

    public function getTechno(): ?string
    {
        return $this->Techno;
    }

    public function setTechno(string $Techno): self
    {
        $this->Techno = $Techno;

        return $this;
    }
}
