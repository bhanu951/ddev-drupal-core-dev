<?php
#ddev-generated

namespace DrupalCoreDev\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class TestCommand extends CommandBase {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this->setName('test')
          ->setDescription('Run all core tests using the run-tests.sh script. You probably don\'t want to do this - instead run PHPUnit directly on selected tests e.g. ddev phpunit core/modules/sdc/tests');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $doc_root = $this->getWebRoot() . '/';
        $io = new SymfonyStyle($input, $output);

        $command = "php .{$doc_root}core/scripts/run-tests.sh --php /usr/bin/php --color --keep-results --concurrency 4 --repeat 1 --sqlite '.{$doc_root}sites/default/files/.sqlite' --verbose --non-html --all";
        $tests = Process::fromShellCommandline($command);
        $output->writeln($command);
        $tests->setTimeout(0);
        $tests->run(function ($type, $data) use ($output) {
            $output->write($data);
        });
        if ($tests->getExitCode()) {
            $io->error($tests->getErrorOutput());
            return 1;
        }
        return 0;
    }
}
