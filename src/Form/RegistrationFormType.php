<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void {
        $builder
            ->add('username', TextType::class, [
                'required' => false, 
                'label' => 'Pseudo',
                'attr' => [ 
                    'class' => 'login__input',
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('password', PasswordType::class, [
              'required' => true,
              'label' => 'Mot de passe',
              'attr' => [
                'class' => 'login__input',
              ]
            ])
            ->add('captcha', CaptchaType::class, [
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
} 