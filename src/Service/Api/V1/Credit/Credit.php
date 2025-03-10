<?php

namespace App\Service\Api\V1\Credit;

use App\Entity\Api\V1\Credit\CreditProgram;
use App\Entity\Api\V1\Credit\CreditProgramRequest;
use Doctrine\ORM\EntityManagerInterface;


class Credit
{
    const MIN_INIT_PAYMENT = 800000;
    const MAX_LOAN_TERM = 24;
    const BORDER_PERCENT = 10;

    public function __construct(protected EntityManagerInterface $manager)
    {
    }

    public function calculateCredit(CreditProgramRequest $request): ?CreditProgram
    {
        if ($request->initialPayment() >= self::MIN_INIT_PAYMENT && $request->loanTerm() <= self::MAX_LOAN_TERM) {
            return $this->manager->getRepository(CreditProgram::class)->getInterestLessThan(self::BORDER_PERCENT);
        }

        return $this->manager->getRepository(CreditProgram::class)->getInterestGreaterThan(self::BORDER_PERCENT);
    }

    public function monthlyPayment(CreditProgramRequest $creditProgramRequest, CreditProgram $creditResponse): int
    {
        $remains = $creditProgramRequest->price() - $creditProgramRequest->initialPayment();
        $monthlyPercent = round($creditResponse->interestRate() / 12 / 100, 4);

        $ratio = $monthlyPercent * (1 + $monthlyPercent) ** $creditProgramRequest->loanTerm() / ((1 + $monthlyPercent) ** $creditProgramRequest->loanTerm() - 1);

        return ceil($remains * $ratio);
    }
}