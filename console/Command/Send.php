<?php

namespace Mitake\Console\Command;

use Mitake\Message\Message;
use Mitake\Console\ClientTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Send
 * @package Mitake\Console\Command
 */
class Send extends Command
{
    use ClientTrait;

    protected function configure()
    {
        $this->setName('send')
            ->setDescription('Send an message')
            ->addOption(
                '--dstaddr',
                '-d',
                InputOption::VALUE_REQUIRED,
                'Destination phone number, for example: 0987654321'
            )
            ->addOption(
                '--smbody',
                '-b',
                InputOption::VALUE_REQUIRED,
                'Message content'
            )
            ->addOption(
                '--dlvtime',
                '-D',
                InputOption::VALUE_OPTIONAL,
                'Delivery time'
            )
            ->addOption(
                '--vldtime',
                '-R',
                InputOption::VALUE_OPTIONAL,
                'Reservation time'
            )
            ->addOption(
                '--response',
                '-r',
                InputOption::VALUE_OPTIONAL,
                'Callback URL to receive the delivery receipt of the message'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->createClient($input);

        if (is_null($input->getOption('dstaddr')) || is_null($input->getOption('smbody'))) {
            throw new \InvalidArgumentException('The --dstaddr and --smbody are required');
        }

        $message = new Message([
            'clientid' => sprintf('%s%04d', base_convert(time(), 10, 36), mt_rand(0, 9999)),
            'dstaddr' => $input->getOption('dstaddr'),
            'smbody' => $input->getOption('smbody'),
        ]);
        if (!is_null($input->getOption('dlvtime'))) {
            $message->set('dlvtime', $input->getOption('dlvtime'));
        }
        if (!is_null($input->getOption('vldtime'))) {
            $message->set('vldtime', $input->getOption('vldtime'));
        }
        if (!is_null($input->getOption('response'))) {
            $message->set('response', $input->getOption('response'));
        }

        $resp = $client->send($message);

        $output->writeln(json_encode($resp->toArray(), JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
