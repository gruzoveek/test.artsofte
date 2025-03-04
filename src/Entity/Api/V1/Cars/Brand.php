<?php

namespace App\Entity\Api\V1\Cars;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;


#[Entity]
class Brand
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    #[Column(type: 'string', options: ['default' => ''])]
    protected string $name;

    #[OneToMany(targetEntity: Car::class, mappedBy: 'brand', cascade: ['persist', 'remove'], fetch: 'EAGER', orphanRemoval: true)]
    protected Collection $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function cars(): Collection
    {
        return $this->cars;
    }

    public function setCars(Collection $cars): static
    {
        $this->cars = $cars;

        return $this;
    }
}