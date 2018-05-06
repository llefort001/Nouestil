<?php

namespace AppBundle\Form;

use AppBundle\Entity\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Email')
            ))
            ->add('firstname', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Prénom')
            ))
            ->add('lastname', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Nom')
            ))
            ->add('phone_number', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Numéro de téléphone')
            ))
            ->add('birth_date', DateType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Date de naissance'),
                'widget'=>'single_text'
            ))
            ->add('city', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Ville')
            ))
            ->add('group', EntityType::class, array(
                'class' => Group::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g');
                },
                'label' => false,
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ))
            ;


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
