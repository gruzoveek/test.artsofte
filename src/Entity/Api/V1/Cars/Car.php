<?php

namespace App\Entity\Api\V1\Cars;

use App\Repository\Api\V1\Cars\CarRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;


#[Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    #[Column(type: 'string', options: ['default' => ''])]
    protected string $photo;

    #[Column(type: 'integer')]
    protected int $price;

    #[ManyToOne(targetEntity: Brand::class, cascade: ['persist'], inversedBy: 'cars')]
    #[JoinColumn(onDelete: 'CASCADE')]
    protected Brand $brand;

    #[ManyToOne(targetEntity: Model::class, cascade: ['persist'], inversedBy: 'cars')]
    #[JoinColumn(onDelete: 'CASCADE')]
    protected Model $model;

    public function __construct(Brand $brand, Model $model, int $price, string $photo)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->price = $price;
        $this->photo = $photo;
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

    public function photo(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function brand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }
}