<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(QuizzRepository $quizzRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'quizzs' => $quizzRepository->findAll(),
        ]);
    }

    #[Route('/infos', name: 'app_infos')]
    public function index1(): Response
    {
        return $this->render('home/infos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

#[Route('/infos', name: 'app_infos')]
public function index1(): Response
{
    return $this->render('home/infos.html.twig', [
        'controller_name' => 'HomeController',
    ]);
}
}
