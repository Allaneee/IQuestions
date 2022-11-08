<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;

#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Wording = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Answers = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\Column(length: 255)]
    private ?string $CorrectAnswer = null;

    #[ORM\ManyToOne(targetEntity: Quizz::class,cascade : ["persist", "remove"], inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quizz $quizz = null;

    #[ORM\OneToMany(mappedBy: 'questions', targetEntity: Answer::class, orphanRemoval: true)]
    private Collection $playeranswers;

    public function __construct()
    {
        $this->playeranswers = new ArrayCollection();
    }
    private $questions;
    
    public function getquestions(){
        return $this->questions;
    }
    public function setQuestions($questions){
        $this->questions=$questions;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWording(): ?string
    {
        return $this->Wording;
    }

    public function setWording(string $Wording): self
    {
        $this->Wording = $Wording;

        return $this;
    }

    public function getAnswers(): ?string
    {
        return $this->Answers;
    }

    public function setAnswers(string $Answers): self
    {
        $this->Answers = $Answers;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getCorrectAnswer(): ?string
    {
        return $this->CorrectAnswer;
    }

    public function setCorrectAnswer(string $CorrectAnswer): self
    {
        $this->CorrectAnswer = $CorrectAnswer;

        return $this;
    }

    public function getQuizz(): ?Quizz
    {
        return $this->quizz;
    }

    public function setQuizz(?Quizz $quizz): self
    {
        $this->quizz = $quizz;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getPlayeranswers(): Collection
    {
        return $this->playeranswers;
    }

    public function addPlayeranswer(Answer $playeranswer): self
    {
        if (!$this->playeranswers->contains($playeranswer)) {
            $this->playeranswers->add($playeranswer);
            $playeranswer->setQuestions($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getWording();
    }
    public function removePlayeranswer(Answer $playeranswer): self
    {
        if ($this->playeranswers->removeElement($playeranswer)) {
            // set the owning side to null (unless already changed)
            if ($playeranswer->getQuestions() === $this) {
                $playeranswer->setQuestions(null);
            }
        }

        return $this;
    }
}
