<?php

namespace AppBundle\Form;

use AppBundle\Repository\CommentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                ->add('deadline', DateType::class, ['years' => range(date('Y'), date('Y') + 10)])
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

       /* $builder->add('comment', EntityType::class, array(
            'class' => 'AppBundle:Comment',
            'query_builder' => function (CommentRepository $er) use ($user) {
                return $er
                    ->createQueryBuilder('cm')
                    ->where('cm.user = :user')
                    ->orderBy('cm.id', 'ASC')
                    ->setParameter('user', $user);
            },
            'choice_label' => 'content',
        ));*/
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
