<?php

namespace DemandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('libele')
                ->add('description')
                ->add('type')
                ->add('niveauUrgence')
                ->add('application')
                ->add('module', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array('class' => 'DemandeBundle\Entity\Module',
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                        return $repository->createQueryBuilder('c')->where('c.actif = 1');
                    }))
                ->add('fichier', \Symfony\Component\Form\Extension\Core\Type\FileType::class, ['required' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DemandeBundle\Entity\Demande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'demandebundle_demande';
    }

}
