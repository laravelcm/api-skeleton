<?php

declare(strict_types=1);

namespace Skeleton\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

final class Reset extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('reset')
            ->setDescription('Reset the skeleton API project');
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $output->write(PHP_EOL.'  <fg=green>Resetting project...</>'.PHP_EOL.PHP_EOL);

        $finder = new Finder();

        $folders = $finder->directories()
            ->exclude(['vendor', 'skeleton', 'projects'])
            ->in(getcwd())
            ->depth(0)
            ->getIterator();

        $files = $finder->files()
            ->notName('*.md')
            ->depth(0)
            ->getIterator();

        $output->write(PHP_EOL.'  <fg=white>Deleting Laravel files & folders...</>'.PHP_EOL.PHP_EOL);

        foreach ($folders as $folder) {
            (new Filesystem)->remove($folder->getRelativePathname());
        }

        foreach ($files as $file) {
            (new Filesystem)->remove($file->getRelativePathname());
        }

        (new Filesystem)->copy('skeleton/stubs/.gitignore', '.gitignore', true);
        (new Filesystem)->copy('skeleton/stubs/composer.stub', 'composer.json', true);
        (new Filesystem)->copy('skeleton/stubs/phpunit.stub', 'phpunit.xml', true);
        (new Filesystem)->copy('skeleton/stubs/README.stub', 'README.md', true);

        $output->write(PHP_EOL.'  <fg=green>Project reset 🎈!</>'.PHP_EOL.PHP_EOL);

        return Command::SUCCESS;
    }
}
