<?php

namespace App\Form\Api\V1\Credit;

use App\Entity\Api\V1\Cars\Car;
use App\Entity\Api\V1\Credit\CreditProgram;
use App\Entity\Api\V1\Credit\CreditRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreditRequestType extends AbstractType
{
    public function __construct(protected EntityManagerInterface $manager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('carId', EntityType::class, [
                'class' => Car::class,
                'choice_value' => 'id',
                'mapped' => false,
            ])
            ->add('programId', EntityType::class, [
                'class' => CreditProgram::class,
                'choice_value' => 'id',
                'mapped' => false,
            ])
            ->add('initialPayment', NumberType::class)
            ->add('loanTerm', NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreditRequest::class,
            'empty_data' => function (FormInterface $form) {
                $car = $this->manager->getRepository(Car::class)->find($form->get('carId')->getData());
                $program = $this->manager->getRepository(CreditProgram::class)->find($form->get('programId')->getData());
                $initialPayment = $form->get('initialPayment')->getData();
                $loanTerm = $form->get('loanTerm')->getData();

                return new CreditRequest(car: $car, creditProgram: $program, initialPayment: $initialPayment, loanTerm: $loanTerm);
            },
        ]);
    }
}