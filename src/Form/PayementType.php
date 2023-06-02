<?php

namespace App\Form;

use App\DTO\Payement;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PayementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardNumber', TextType::class, [
                "label" => "N° de carte:",
                "required" => true
            ])
            ->add('cardName', TextType::class, [
                "label" => "Nom de la carte:",
                "required" => true
            ])
            ->add('expirationDate', TextType::class, [
                "label" => "Date d'expiration:",
                "required" => true
            ])
            ->add('cvc', TextType::class, [
                "label" => "CVC:",
                "required" => true
            ])
            ->add('address', AddressType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payement::class,
        ]);
    }
}
