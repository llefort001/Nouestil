<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('amount', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Montant en €', 'required' => 'required')
            ))
            ->add('user', User::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Nom d\'utilisateur', 'required' => 'required')
            ))
            ->add('user', EntityType::class, array(
                'label' => 'Nom d\'utilisateur ',
                'class' => 'PortailMkgBundle\Entity\User',
                'choice_label' => 'Nom d\'utilisateur',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($user) {
                    return $er->queryNotUserApis($userApi->getIdFosUser());
                },
                'attr' => array('class' => 'form-control')
            ))
            ->add('method', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Méthode', 'required' => 'required')
            ))
            ->add('datetime', DateTimeType::class, array('label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Date du paiement', 'required' => 'required')
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
