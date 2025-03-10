<?php

namespace App\Entity\Api\V1\Credit;

use App\Repository\Api\V1\Credit\CreditProgramRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;


#[Entity(repositoryClass: CreditProgramRepository::class)]
class CreditProgram
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    #[Column(type: 'decimal', precision: 10, scale: 2)]
    protected float $initialPayment;

    #[Column(type: 'decimal', precision: 4, scale: 1)]
    protected float $interestRate;

    #[Column(type: 'integer')]
    protected int $loanTerm;

    #[Column(type: 'string')]
    protected string $title;

    public function __construct(float $initialPayment, float $interestRate, int $loanTerm, string $title)
    {
        $this->initialPayment = $initialPayment;
        $this->interestRate = $interestRate;
        $this->loanTerm = $loanTerm;
        $this->title = $title;
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

    public function initialPayment(): float
    {
        return $this->initialPayment;
    }

    public function setInitialPayment(float $initialPayment): static
    {
        $this->initialPayment = $initialPayment;

        return $this;
    }

    public function interestRate(): float
    {
        return $this->interestRate;
    }

    public function setInterestRate(float $interestRate): static
    {
        $this->interestRate = $interestRate;

        return $this;
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

    public function title(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}