<?php

/**
 * Created by PhpStorm.
 * User: roman
 * Date: 25.09.17
 * Time: 16:01
 */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteOldMessageCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('delete_old:messages')
            ->addArgument('count', InputArgument::REQUIRED, 'How many messages do you want to delete?')
            ->setDescription('Command to delete old messages');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $ids = $em->getRepository('AppBundle:Message')->selectOldMessages($input->getArgument('count'));
        $em->getRepository('AppBundle:Message')->deleteOldMessages($ids);

        $date = new \DateTime();
        $output->writeln('Delete ' . $input->getArgument('count') . ' old messages ' . $date->format('Y-m-d H:i:s'));
    }
}