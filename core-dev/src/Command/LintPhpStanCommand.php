<?php
#ddev-generated

namespace DrupalCoreDev\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class LintPhpStanCommand extends CommandBase {
    /**
     * {@inheritdoc}
     */
    protected function configure(): void {
        $this->setName('lint:phpstan')
            ->setDescription('Run PHPStan code quality analysis against core.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $doc_root = $this->getWebRoot() . '/';
        $command = "php vendor/bin/phpstan analyze --configuration=./{$doc_root}core/phpstan.neon.dist --error-format=table";
        $phpcs = Process::fromShellCommandline($command);
        $output->writeln($command);
        $phpcs->setTimeout(0);
        $phpcs->run(function ($type, $data) use ($output) {
            $output->write($data);
        });
        if ($phpcs->getExitCode()) {
            return 1;
        }
        return 0;
    }
}
