<?php
namespace SWP\BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AccountType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                'disabled' => true
            ))
            ->add('currentPassword', 'password', array(
                'mapped' => false,
                'label'  => 'account.password.current'
            ))
            ->add('password', 'repeated', array(
                'type'            => 'password',
                'invalid_message' => 'account.password.mismatch',
                'options'         => array(
                    'attr' => array(
                        'class' => 'password-field'
                    )
                ),
                'required'        => true,
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'account';
    }
}
