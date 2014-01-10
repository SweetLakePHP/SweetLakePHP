<?php

namespace SWP\BackendBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use SWP\BackendBundle\Entity\User;

class UserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create a new user')
            ->addArgument(
                'email',
                InputArgument::OPTIONAL,
                'Please give the email of the new user'
            )
            ->addArgument(
               'password',
               InputArgument::OPTIONAL,
               'Set the new password of the user'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email    = $input->getArgument('email');
        $password = $input->getArgument('password');

        $factory = $this->getContainer()->get('security.encoder_factory');
        $user    = new User();

        // set email
        $user->setEmail($email);

        // set passowrd
        $encoder = $factory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($encodedPassword);

        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $em->persist($user);
        $em->flush();

        $output->writeln('Created sucessfully user ' . $email);
    }
}