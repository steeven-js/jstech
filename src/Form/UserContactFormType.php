<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'disabled' => true,
            'label' => 'Votre prénom'
        ])
        ->add('lastname', TextType::class, [
            'disabled' => true,
            'label' => 'Votre nom'
        ])
        ->add('email', EmailType::class, [
            'disabled' => true,
        ])
        ->add('subject', TextType::class, [
                'label' => 'Sujet',
        ])
        ->add('message', TextareaType::class, [
                'label' => 'Description',
        ])
        ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-main'
                ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
