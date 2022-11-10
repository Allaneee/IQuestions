<?php

namespace App\Controller;

use App\Entity\Play;
use App\Entity\Quizz;
use App\Form\PlayType;
use App\Repository\PlayRepository;
use App\Repository\QuestionsRepository;
use App\Repository\QuizzRepository;
use Doctrine\ORM\Mapping\Id;
use LDAP\Result;
use phpDocumentor\Reflection\Types\Integer;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/play')]
class PlayController extends AbstractController
{

    #[Route('/{id}', name: 'app_play', methods:['GET'])]
    public function index(Request $request, Quizz $quizz, QuestionsRepository $questionsRepository): Response
    {
        $questions = $questionsRepository->findByQuizz($quizz);
        foreach ($questions as $question) {
            $quizz->addQuestion($question);
        }

        if($request->query->all() != []){
            //Calculer le score
            // return $this->render('play/index.html.twig', [
            //     'result' => $this->result($request->query->all(), $quizz),
            // ]);
        }
        return $this->render('play/index.html.twig', [
            'quizz' => $quizz,
            'questions' => $questions,
        ]);
    }

    public function result(Array $answered, Quizz $quizz)
    {
        $result = 0;
        foreach ($quizz->getQuestions() as $question) {
            if ($question->getCorrectAnswer() == $answered[$question->getId()]) {
                $result += 1;
            }
        }
        return $result;
    }
    





    #[Route('/new', name: 'app_play_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlayRepository $playRepository): Response
    {
        $play = new Play();
        $form = $this->createForm(PlayType::class, $play);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playRepository->save($play, true);

            return $this->redirectToRoute('app_play_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('play/new.html.twig', [
            'play' => $play,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_play_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Play $play, PlayRepository $playRepository): Response
    {
        $form = $this->createForm(PlayType::class, $play);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playRepository->save($play, true);

            return $this->redirectToRoute('app_play_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('play/edit.html.twig', [
            'play' => $play,
            'form' => $form,
        ]);
    }
}
