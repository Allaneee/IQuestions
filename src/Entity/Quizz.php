<?php

namespace App\Entity;

use App\Repository\QuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Component\Console\Question\Question;

#[ORM\Entity(repositoryClass: QuizzRepository::class)]
class Quizz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Theme = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Difficulty = null;

    #[ORM\ManyToOne(inversedBy: 'createdquizz')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Author = null;
    
    #[ORM\OneToMany(mappedBy: 'quizz',cascade : ["persist", "remove"], targetEntity: Questions::class, orphanRemoval: true)]
    private Collection $questions;

    #[ORM\OneToMany(mappedBy: 'quizz', targetEntity: Play::class, orphanRemoval: true)]
    private Collection $played;

    #[ORM\Column]
    private ?bool $Hide = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->played = new ArrayCollection();
        $this->setHide(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?string
    {
        return $this->Theme;
    }

    public function setTheme(string $Theme): self
    {
        $this->Theme = $Theme;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->Difficulty;
    }

    public function setDifficulty(int $Difficulty): self
    {
        $this->Difficulty = $Difficulty;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

        return $this;
    }  

    /**
     * @return Collection<int, Questions>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Questions $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuizz($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuizz() === $this) {
                $question->setQuizz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Play>
     */
    public function getPlayed(): Collection
    {
        return $this->played;
    }

    public function addPlayed(Play $played): self
    {
        if (!$this->played->contains($played)) {
            $this->played->add($played);
            $played->setQuizz($this);
        }

        return $this;
    }

    public function removePlayed(Play $played): self
    {
        if ($this->played->removeElement($played)) {
            // set the owning side to null (unless already changed)
            if ($played->getQuizz() === $this) {
                $played->setQuizz(null);
            }
        }

        return $this;
    }

    public function isHide(): ?bool
    {
        return $this->Hide;
    }

    public function setHide(bool $Hide): self
    {
        $this->Hide = $Hide;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
