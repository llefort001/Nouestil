<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                'choice_label' => 'username',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'DESC');
                },
                'label' => false,
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ))
            ->add('email', EmailType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required')
            ))
            ->add('firstname', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Prénom', 'required' => 'required')
            ))
            ->add('lastname', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Nom', 'required' => 'required')
            ))
            ->add('kinship', ChoiceType::class, array('label' => false,
                'choices' => array(
                    'Parent' => 'parent',
                    'Représentant autre' => 'autre',
                    ),
                'attr' => array('class' => 'form-control', 'placeholder' => 'Lien de parenté', 'required' => 'required')
            ))
            ->add('phone_number', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Numéro de téléphone', 'required' => 'required')
            ));
    }

    /**
     * {@inheritdoc}
     */
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'AppBundle\Entity\Contact'
//        ));
//    }
}
