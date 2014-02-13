<?php

namespace SWP\BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints;

class WriteupType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', 'text', array(
                'constraints' => array(
                   new Constraints\NotBlank()
                )
            ))
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'input-block-level'
                ),
                'constraints' => array(
                    new Constraints\NotBlank()
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SWP\BackendBundle\Entity\Writeup'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'writeup';
    }
}
