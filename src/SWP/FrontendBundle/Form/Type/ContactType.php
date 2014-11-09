<?php

namespace SWP\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'constraints' => new Length(array('min' => 3)),
            ))
            ->add('email', 'email', array(
                'constraints' => array(
                    new NotBlank(),
                    new Email()
                )
            ))
            ->add('subject', 'text', array(
                'constraints' => new Length(array('min' => 3)),
            ))
            ->add('content', 'textarea', array(
                'attr'        => array(
                    'class' => 'input-block-level'
                ),
                'constraints' => new Length(array('min' => 10, 'max' => 800)),
            ))
            ->add('captcha', 'captcha', array(
                'label'  => 'contact.captcha.title',
                'reload' => true,
                'as_url' => 'gregwar_captcha.generate_captcha',
                'attr'   => array(
                    'help' => 'contact.captcha.refresh'
                )
            ));
    }

    public function getName()
    {
        return 'contact';
    }
}
