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
            ->add('title', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Intitulé')
            ))
            ->add('amount', NumberType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Montant')
            ))
            ->add('datetime', DateType::class, array('label' => false,
                'attr' => array('class' => 'form-control'),
                'widget' => 'single_text',
                'years' => range(date('Y'), date('Y') + 100),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
            ))
            ->add('user', EntityType::class, array('label' => false,
                'class' => User::class,
//                'choice_label' => 'username', not needed because class has a __toString() method sending name + surname
                'attr' => array('class' => 'form-control')
            ))
            ->add('note', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Note'), 'required' => false
            ))
            ->add('method', ChoiceType::class, array('label' => false,
                'choices' => array(
                    'CB' => 'Credit Card',
                    'Especes' => 'Cash',
                    'Virement' => 'Transfer',
                    'Autre' => 'Other'
                ),
                'placeholder' => '-- Choisir une méthode --',
                'required' => true,
                'attr' => array('class' => 'form-control')

            ))
            ->add('category', ChoiceType::class, array('label' => false,
                'choices' => array(
                    'Paiement' => 'Payment',
                    'Remboursement' => 'Refund',
                ),
                'placeholder' => '-- Choisir une catégorie --',
                'required' => true,
                'attr' => array('class' => 'form-control')

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
