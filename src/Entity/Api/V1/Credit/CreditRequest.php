<?php

namespace App\Entity\Api\V1\Credit;

use App\Entity\Api\V1\Cars\Car;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\Validator\Constraints as Assert;


#[Entity]
#[HasLifecycleCallbacks]
class CreditRequest
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    #[ManyToOne(targetEntity: Car::class)]
    protected Car $car;

    #[ManyToOne(targetEntity: CreditProgram::class)]
    protected CreditProgram $creditProgram;

    #[Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\GreaterThan(value: 0, message: 'Первоначальный платеж должен быть больше {{ compared_value }}₽')]
    protected float $initialPayment;

    #[Column(type: 'integer')]
    #[Assert\GreaterThan(value: 0, message: 'Срок кредита должен быть больше {{ compared_value }} месяцев')]
    #[Assert\LessThanOrEqual(value: 240, message: 'Срок кредита не может быть больше {{ compared_value }} месяцев')]
    protected int $loanTerm;

    #[Column(type: 'datetime', nullable: true)]
    protected DateTimeImmutable $created;

    public function __construct(Car $car, CreditProgram $creditProgram, float $initialPayment, int $loanTerm)
    {
        $this->car = $car;
        $this->creditProgram = $creditProgram;
        $this->initialPayment = $initialPayment;
        $this->loanTerm = $loanTerm;
    }

    public function loanTerm(): int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(int $loanTerm): static
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }

    public function initialPayment(): float
    {
        return $this->initialPayment;
    }

    public function setInitialPayment(float $initialPayment): static
    {
        $this->initialPayment = $initialPayment;

        return $this;
    }

    public function creditProgram(): CreditProgram
    {
        return $this->creditProgram;
    }

    public function setCreditProgram(CreditProgram $creditProgram): static
    {
        $this->creditProgram = $creditProgram;

        return $this;
    }

    public function car(): Car
    {
        return $this->car;
    }

    public function setCar(Car $car): static
    {
        $this->car = $car;

        return $this;
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

    public function created(): DateTimeImmutable
    {
        return $this->created;
    }

    #[PrePersist]
    public function setCreated(): void
    {
        $this->created = new DateTimeImmutable();
    }
}