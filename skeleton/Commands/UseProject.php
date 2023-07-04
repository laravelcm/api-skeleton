<?php

declare(strict_types=1);

namespace Skeleton\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

final class UseProject extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('use')
            ->setDescription('Use a project as scaffold for a new Laravel API skeleton')
            ->addArgument('name', InputArgument::REQUIRED, 'The project to use as scaffold');
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $output->write(PHP_EOL.'  <fg=green>Find project 🔍...</>'.PHP_EOL.PHP_EOL);

        $name = $input->getArgument('name');
        $project = 'projects/'.$name;

        if (! file_exists($project)) {
            $output->write(PHP_EOL.'  <fg=red>Project not found!</>'.PHP_EOL.PHP_EOL);

            return Command::FAILURE;
        }

        $output->write(PHP_EOL.'  <fg=white>Coping files & folders!</>'.PHP_EOL.PHP_EOL);

        $finder = new Finder();
        $files = $finder->in($project)
            ->files()
            ->depth(0)
            ->getIterator();

        (new Filesystem)->mirror($project, getcwd());

        foreach ($files as $file) {
            (new Filesystem)->copy($file->getRealPath(), $file->getRelativePathname(), true);
        }

        $output->write(PHP_EOL.'  <fg=green>Project ready! 🚀</>'.PHP_EOL.PHP_EOL);

        return Command::SUCCESS;
    }
}
