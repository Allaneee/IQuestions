<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $question = $options['question'];
        $choiseArray = [];
        foreach ($question->getAnswers() as $choix) {
            $choiseArray[$choix] = $choix;
        }

        $builder
            ->add('AnswerUser', ChoiceType::class, ['choices' => $choiseArray ,'label' => $question->getWording()]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'question' => Questions::class,
        ]);
    }
}
