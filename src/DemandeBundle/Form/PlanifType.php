<?php

namespace DemandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanifType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('duree')
                ->add('user')
                ->add('gerant', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                    'class' => 'UserBundle\Entity\Utilisateur',
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                        return $repository->createQueryBuilder('c')->where('c.level = 3');
                    }))
                ->add('demande');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DemandeBundle\Entity\Planif'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'demandebundle_planif';
    }

}
