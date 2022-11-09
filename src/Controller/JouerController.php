<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Form\UserQuizzAnswersType;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JouerController extends AbstractController
{
    #[Route('/game/{id}', name: 'app_jouer', methods: ['GET', 'POST'])]
    public function index(HttpFoundationRequest $request, Quizz $quizz, QuestionsRepository $questionsRepository ): Response
    {
        $questions = $questionsRepository->findByQuizz($quizz);
        foreach ($questions as $question) {
            $quizz->addQuestion($question);
        }

        $array[] = [];

        $form = $this->createForm(UserQuizzAnswersType::class, $array ,['quizz' => $quizz]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('app_quizz_show', ['id' => $quizz->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jouer/index.html.twig', [
            'controller_name' => 'JouerController',
            'quizz' => $quizz,
            'form' => $form->createView()
        ]);
    }
}
