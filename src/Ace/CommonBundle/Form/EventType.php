<?php

namespace Ace\CommonBundle\Form;

use Ace\CommonBundle\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('intro')
            ->add('content')
            ->add('start')
            ->add('end')
            ->add('blogs')
            ->add(
                'image',
                'jb_crop_image_ajax',
                [
                    'endpoint' => 'gallery',
                    'img_width' => 100,
                    'crop_options' => [
                        'aspect-ratio' => 1,
                        'set-select' => "[5,5,20,20]"
                    ]
                ]
            );

        if ($options['add_submit_buttons']) {
            $builder->add('submit', 'submit');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Entity\Event::class,
                'add_submit_buttons' => false
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ace_common_event';
    }
}
