<?php
namespace Magento\CommandExample\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputOption;

/**
 * Class StoreListCommand
 *
 * Command for listing the configured stores
 */
class SomeCommand extends Command
{
//    const NAME = 'name';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('generator:module');
        $this->setDescription('This is my first console command.');
        $this->addOption(
            self::NAME,
            null,
            InputOption::VALUE_REQUIRED,
            'Name'
        );

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        if ($name = $input->getOption(self::NAME)) {
//            $output->writeln('<info>Provided name is `' . $name . '`</info>');
//        }

        $output->writeln("Hello World");
        $output->writeln('<info>Success Message.</info>');
        $output->writeln('<error>An error encountered.</error>');
        $output->writeln('<comment>Some Comment.</comment>');
    }
}
