<?php

namespace App\Form;

use App\Entity\Quizz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\SecurityContext;

class UserQuizzAnswersType extends AbstractType
{
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // foreach ($quizz->getQuestions() as $question) {
        //     $builder->add('userAnswer', AnswerType::class, ['question' => $question]);
        // }

        // foreach ($quizz->getQuestions() as $question) {
        //     $builder->add('questions', CollectionType::class, [
        //         'entry_type' => AnswerType::class,
        //         'entry_options' => ['question' => $question],
        //     ]);
        // }

        dd($this->securityContext);

        $builder->add('questions', CollectionType::class, []);

    	$builder->addEventListener(
        	FormEvents::POST_SET_DATA,
	        function (FormEvent $event) {

	            $form = $event->getForm();
                $data = $event->config->options;
                dd($data);
                

	            foreach ($quizz->getQuestions() as $question) {
                    $form
                        ->get('questions')
                        ->add('questions', CollectionType::class, [
                            'entry_type' => AnswerType::class,
                            'entry_options' => ['question' => $question],
                        ]);
                }
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'quizz' => false
        ]);

        $resolver->setAllowedTypes('quizz', Quizz::class);
    }
}
