<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "Nom: ",
                "required" => true
            ])
            ->add("lastname", TextType::class,[ 
                "label" => "Prenom: ",
                "required" => true
            ])
            ->add("phone", TelType::class, [
                "label" => "Téléphone: ",
                "required" => true
            ])
            ->add('email', EmailType::class, [
                "label" => "Votre Email: ",
                "required" => true
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Le mot de passe doit être similaire",
                "required" => true,
                "first_options" => ["label" => "Mot de passe:"],
                "second_options" => ["label" => "Répéter le mot de passe:"]
            ])
            ->add('address', AddressType::class, ["label" => "Adresse:"])
            ->add('submit', SubmitType::class, [
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
