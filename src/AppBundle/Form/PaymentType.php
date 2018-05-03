<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PaymentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', NumberType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Montant', 'required' => 'required')
            ))
            ->add('datetime', DateType::class, array('label' => false,
                'attr' => array('class' => 'form-control','required' => 'required'),
                'widget' => 'single_text',
                'years' => range(date('Y'), date('Y') + 100),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
            ))
            ->add('user', EntityType::class, array('label' => false,
                'class' => User::class,
                'choice_label' => 'username',
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ))
            ->add('note', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Note',)
            ))
            ->add('method', ChoiceType::class, array('label' => false,
                'choices' => array(
                    '--Choisir une méthode--' => null,
                    'CB' => 'Credit Card',
                    'Especes' => 'Cash',
                    'Virement' => 'Transfer',
                    'PayPal' => 'Paypal',
                    'Autre' => 'Other'
                ),
                'choice_attr' => function($val, $key, $index) {
                    if ($val==null) {
                        $disabled = true;
                    } else {
                        $disabled = false;
                    }
                    return $disabled ? ['disabled' => 'disabled'] : [];
                },
                'attr' => array('class' => 'form-control', 'required' => 'required')

            ))
            ->add('category', ChoiceType::class, array('label' => false,
                'choices' => array(
                    '--Choisir une catégorie--' => null,
                    'Paiement' => 'Payment',
                    'Remboursement' => 'Refund',
                ),
                'choice_attr' => function($val, $key, $index) {
                    if ($val==null) {
                        $disabled = true;
                    } else {
                        $disabled = false;
                    }
                    return $disabled ? ['disabled' => 'disabled'] : [];
                },
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Payment'
        ));
    }
}
