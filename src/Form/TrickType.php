<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Name of trick'])
            ->add('TrickGroup', EntityType::class, array(
                'class' => TrickGroup::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('tg')
                        ->orderBy('tg.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Category'
            ))
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('Pictures', CollectionType::class, array(
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => PicturesType::class,
                'prototype' => true,
                'label' => 'Related pictures',
                'attr' => array(
                    'class' => 'collection-trick'
                ),
                'entry_options' => [
                    'label' => 'A picture',
                    'label_attr' => ['class' => 'font-weight-light']
                ],
                'by_reference' => false
            ))
            ->add('Movies', CollectionType::class, array(
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => MoviesType::class,
                'prototype' => true,
                'label' => 'Related movies',
                'attr' => array(
                    'class' => 'collection-trick',
                ),
                'entry_options' => [
                    'label' => 'Youtube movie',
                    'label_attr' => ['class' => 'font-weight-light']
                ],
                'by_reference' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'allow_extra_fields' => false
        ]);
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'AddressType';
    }
}
