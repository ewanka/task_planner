<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Controller\TaskController;
use AppBundle\Repository\CategoryRepository;

class TaskType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        
        $builder
                ->add('name')
                ->add('description')
                ->add('deadline')
                ->add('priority')
                ->add('status');

        $builder->add('category', EntityType::class, array(
            'class' => 'AppBundle:Category',
            'query_builder' => function (CategoryRepository $er) use ($user) {
                return $er
                        ->createQueryBuilder('c')
                        ->where('c.user = :user')
                        ->orderBy('c.id', 'ASC')
                        ->setParameter('user', $user);
            },
            'choice_label' => 'name',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task'
        ));
        $resolver->setRequired(array(
            'user'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_task';
    }

}
