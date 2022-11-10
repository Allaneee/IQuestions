<?php

namespace App\Form;

use App\Entity\Quizz;
use App\Entity\Questions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;


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
                    'Voyage' => "Voyage",]
            ])
            ->add('Title')
            ->add('Description', TextareaType::class)
            ->add('Theme', ChoiceType::class, [
                'choices' => [
                    'Sport' => "Sport",
                    'Gaming' => "Gaming",
                    'Cinema' => "Cinema",
                    'Fun' => "Fun",
                    'Culutre Générale' => "Culutre Générale",
                    'Sciences' => "Sciences",
                    'Histoire' => "Histoire",
                    'Film' => "Film",
                    'Géographie' => "Géographie", 
                    'Animaux' => "Animaux",
                    'Pop Culture' => "Pop Culture",
                    'Géographie' => "Géographie",
                    'Autre' => "Autre"
                ]
            ])
                    
            ->add('Difficulty', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5
                ]
            ])
            ->add('Questions', CollectionType::class, [
                'entry_type' => QuestionsType::class,
                'label' => 'Questions',
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('imageFile', VichImageType::class)
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}
