<?php

namespace App\Controller\Api\V1;

use App\Entity\Api\V1\Cars\Car;
use App\Form\Api\V1\Credit\CreditProgramRequestType;
use App\Form\Api\V1\Credit\CreditRequestType;
use App\Service\Api\V1\Credit\Credit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route(path: '/api/v1', name: 'api_v1_')]
class ShowcaseApiController extends AbstractController
{
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app.swagger_ui');
    }

    #[Route(path: '/cars', name: 'cars', methods: ['GET'])]
    public function cars(EntityManagerInterface $manager): JsonResponse
    {
        $cars = $manager->getRepository(Car::class)->getCarsList();

        return $this->json($cars);
    }

    #[Route(path: '/cars/{id}', name: 'cars_show', methods: ['GET'])]
    public function carsShow(Car $car, EntityManagerInterface $manager): JsonResponse
    {
        $car = $manager->getRepository(Car::class)->getCar($car->id());

        return $this->json($car);
    }

    #[Route(path: '/credit/calculate', name: 'credit_calculate', methods: ['GET'])]
    public function creditCalculate(Request $request, EntityManagerInterface $manager, Credit $service): JsonResponse
    {
        $form = $this->createForm(CreditProgramRequestType::class);

        $data = [
            'price' => $request->get('price'),
            'initialPayment' => $request->get('initialPayment'),
            'loanTerm' => $request->get('loanTerm'),
        ];
        $form->submit($data);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $creditProgramRequest = $form->getData();

                $manager->persist($creditProgramRequest);
                $manager->flush();

                $creditResponse = $service->calculateCredit($creditProgramRequest);

                if (null === $creditResponse) {
                    return $this->json(['success' => false, 'message' => 'Подходящей кредитной программы не найдено']);
                }

                return $this->json([
                    'programId' => $creditResponse->id(),
                    'interestRate' => $creditResponse->interestRate(),
                    'monthlyPayment' => $service->monthlyPayment($creditProgramRequest, $creditResponse),
                    'title' => $creditResponse->title(),
                ]);
            } else {
                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[$error->getOrigin()->getName()] = $error->getMessage();
                }

                return $this->json(['success' => false, 'errors' => $errors]);
            }
        }

        return $this->json(['success' => false, 'message' => 'Неверно переданы параметры']);
    }

    #[Route(path: '/request/', name: 'request', methods: ['POST'])]
    public function request(Request $request, EntityManagerInterface $manager): JsonResponse
    {
        $form = $this->createForm(CreditRequestType::class);

        $form->submit($request->getPayload()->all());
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $creditRequest = $form->getData();

                $manager->persist($creditRequest);
                $manager->flush();

                return $this->json(['success' => true]);
            } else {
                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[$error->getOrigin()->getName()] = $error->getMessage();
                }

                return $this->json(['success' => false, 'errors' => $errors]);
            }
        }

        return $this->json(['success' => false, 'message' => 'Необходимо отправить запрос на кредит']);
    }
}
