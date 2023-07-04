<?php

declare(strict_types=1);

namespace Skeleton\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

final class Available extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('available')
            ->setDescription('List of all available API skeletons');
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $finder = new Finder();
        $folders = $finder->directories()
            ->in(getcwd() . '/projects')
            ->depth(0)
            ->getIterator();

        $output->write(PHP_EOL.'  <fg=green>Available API skeletons:</>'.PHP_EOL.PHP_EOL);

        foreach ($folders as $folder) {
            $output->write('  <fg=yellow> - '.$folder->getFilename().'</>'.PHP_EOL);
        }

        return Command::SUCCESS;
    }
}
