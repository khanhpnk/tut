<?php
namespace Pnk\CoreCommand\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratorCommand extends Command
{
    const VENDOR = 'vendor';
    const MODULE = 'module';

    /**
     * Your command should have an unique name, defined in the configure() method or passing on construct.
     * We set in configure(), not passing on construct.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('generator:code');
        $this->setDescription('Demo command line');

        $this->setDefinition([
            new InputOption(self::VENDOR, null, InputOption::VALUE_REQUIRED, 'Define the vendor'),
            new InputOption(self::MODULE, null, InputOption::VALUE_REQUIRED, 'Define the module name')
        ]);

        parent::configure();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $vendor = $input->getOption(self::VENDOR);
        $this->validate(self::VENDOR, $vendor);

        $module = $input->getOption(self::MODULE);
        $this->validate(self::MODULE, $module);

        var_dump($vendor);
        var_dump($module);
    }

    /**
     * Validates the input option.
     *
     * @param string $name  The short option key
     * @param mixed  $value The value for the option
     *
     * @throws InvalidOptionException If option is invalid
     */
    private function validate(string $name, $value)
    {
        if (null === $value) {
            throw new InvalidOptionException(sprintf('The command require run with "--%s" option.', $name));
        } elseif ('' === $value) {
            throw new InvalidOptionException(sprintf('The "--%s" option requires a value.', $name));
        }
    }
}
