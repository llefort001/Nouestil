<?php

namespace AppBundle\Form;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CourseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Nom du cours', 'required' => 'required')
            ))
            ->add('session', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Intitulé de la session', 'required' => 'required')
            ))
            ->add('userTeach', EntityType::class, array(
                'label' => 'Nom du professeur ',
                'class' => User::class,
                'choice_label' => 'firstname',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er){
                    return $er->findProfessor();
                },
                'attr' => array('class' => 'form-control')
            ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course'
        ));
    }
}
