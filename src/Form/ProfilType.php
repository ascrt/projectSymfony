<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "Nom:",
                "required" => true
            ])
            ->add('lastname',TextType::class, [
                "label" => "Prenom:",
                "required" => true
            ])
            ->add('phone', TelType::class, [
                "label" => "Téléphone:",
                "required" => true
            ])
            ->add('address', AddressType::class)
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Le mot de passe doit être similaire",
                "required" => true,
                "first_options" => ["label" => "Mot de passe:"],
                "second_options" => ["label" => "Répéter le mot de passe:"]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
