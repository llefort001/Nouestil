<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array(
                'class' => User::class,
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'DESC');
                },
                'label' => false,
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ))
            ->add('email', EmailType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Email')
            ))
            ->add('firstname', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Prénom')
            ))
            ->add('lastname', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Nom')
            ))
            ->add('kinship', ChoiceType::class, array('label' => false,
                'choices' => array(
                    'Papa' => 'Dad',
                    'Maman' => 'Mom',
                    'Représentant autre' => 'Other',
                ),
                'placeholder' => '-- Choisir un type --',
                'required' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('phone_number', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Numéro de téléphone', 'required' => 'required')
            ));
    }
}
