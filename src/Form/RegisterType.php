<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Your first name'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Your last name'
            ])
            ->add('userName', TextType::class, [
                'label' => 'Your username'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Your password'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Your email'
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Your avatar'
            ])
            ->add('Sign in', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-block btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'class' => 'text-center'
            ]
        ]);
    }
}
