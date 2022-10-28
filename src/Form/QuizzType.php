<?php

namespace App\Form;

use App\Entity\Quizz;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class QuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Difficulty')
            ->add('Theme', ChoiceType::class, [
                'choices'=> [
                    'Sport' => "sport",
                    'Gaming' => "gaming",
                    'Voyage' => "Voyage",
                    'Fun' => "Fun",
                    'Culutre Générale' => "Culutre Générale",
                    'Sciences' => "Sciences",
                    'Histoire' => "Histoire",
                    'Film' => "Film",
                    'Géographie' => "Géographie", 
                    'Animaux' => "Animaux"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}
