<?php

namespace App\Form\Api\V1\Credit;

use App\Entity\Api\V1\Cars\Car;
use App\Entity\Api\V1\Credit\CreditProgramRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreditProgramRequestType extends AbstractType
{
    public function __construct(protected EntityManagerInterface $manager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', NumberType::class)
            ->add('initialPayment', NumberType::class)
            ->add('loanTerm', NumberType::class);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (PostSubmitEvent $event): void {
            $form = $event->getForm();
            $price = $event->getData()?->price();

            if (!empty($price)) {
                $availablePrices = $this->manager->getRepository(Car::class)->getPrices();

                if (!in_array($price, $availablePrices)) {
                    $form->get('price')->addError(new FormError('Не найдено автомобилей с такой ценой'));
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreditProgramRequest::class,
            'empty_data' => function (FormInterface $form) {
                $price = $form->get('price')->getData();
                $initialPayment = $form->get('initialPayment')->getData();
                $loanTerm = $form->get('loanTerm')->getData();

                return new CreditProgramRequest(price: $price, initialPayment: $initialPayment, loanTerm: $loanTerm);
            },
        ]);
    }
}