<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Email','required' => 'required')
            ))
            ->add('username', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Nom d\'utilisateur','required' => 'required')
            ))
            ->add('firstname', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Prénom','required' => 'required')
            ))
            ->add('lastname', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Nom','required' => 'required')
            ))
            ->add('phone_number', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Numéro de téléphone','required' => 'required')
            ))
            ->add('birth_date', DateType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Date de naissance','required' => 'required'),
                'widget'=>'single_text'
            ))
            ->add('address', TextType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Adresse','required' => 'required')
            ))
            ->add('plainPassword', PasswordType::class, array('label' =>false,
                'attr' => array('class' => 'form-control','placeholder' => 'Mot de passe','required' => 'required')
            ));


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
