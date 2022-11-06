<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Play;
use App\Entity\Quizz;
use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JouerController extends AbstractController
{
    #[Route('/game/{id}', name: 'app_jouer', methods: ['GET', 'POST'])]
    public function index(Quizz $quizz, QuestionsRepository $questionsRepository ): Response
    {
        $questions = $questionsRepository->findByQuizz($quizz);

        $userReponse = new Answer();
        $userReponse->setPlayer($this->getUser());

        foreach ($questions as $question){
            $quizz->addQuestion($question);
            $userReponse->setQuestions($question);

            $form[] = $this->createForm(Answer::class, $question);
        }

        foreach ($form as $forms){
            $form->handleRequest($question);
        }

        return $this->render('jouer/index.html.twig', [
            'controller_name' => 'JouerController',
            'questions' => $quizz->getQuestions(),
            'quizz' => $quizz,
            'form' => $forms
        ]);
    }
}
