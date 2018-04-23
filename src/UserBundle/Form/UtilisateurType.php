<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nom')
                ->add('sexe', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, array(
                    'choices' => array('Homme' => 'Homme', 'Femme' => 'Femme'),
                    'expanded' => true,
                    'multiple' => false
                ))
                ->add('cni')
                ->add('telephone')
                ->add('adresse')
                ->add('level')
                ->add('entreprise');
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Utilisateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'userbundle_utilisateur';
    }

}
