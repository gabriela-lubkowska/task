<?php

namespace App\Form;

use App\Entity\CurrencyOrder;
use App\Entity\PickupPoint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('addressLine1', TextType::class)
            ->add('addressLine2', TextType::class)
            ->add('city', TextType::class)
            ->add('postalCode', TextType::class)
            ->add('phone', TextType::class)
            ->add('pickupPoint', ChoiceType::class, [
                'choices' => $options['pickup_points'],
                'choice_label' => 'name',
                'choice_value' => 'id',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Place Order']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CurrencyOrder::class,
        ]);
        $resolver->setRequired('pickup_points');
    }
}