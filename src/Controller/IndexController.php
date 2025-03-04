<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;


class IndexController extends AbstractController
{
    #[Route(path: '/')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('api_v1_index');
    }
}
