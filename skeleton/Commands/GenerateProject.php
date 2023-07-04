<?php

declare(strict_types=1);

namespace Skeleton\Commands;

use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

final class GenerateProject extends Command
{
    protected function configure(): void
    {
       $this
           ->setName('generate')
           ->setDescription('Generate a new Laravel API Skeleton')
           ->addArgument('name', InputArgument::REQUIRED)
           ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force generate event if the project already exists');
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $output->write(PHP_EOL.'  <fg=red>
         ___            _____      ________          ________      ________    ___
        |\  \          / __  \    |\   __  \        |\   __  \    |\   __  \  |\  \
        \ \  \        |\/_|\  \   \ \  \|\  \       \ \  \|\  \   \ \  \|\  \ \ \  \
         \ \  \       \|/ \ \  \   \ \  \\\  \       \ \   __  \   \ \   ____\ \ \  \
          \ \  \____       \ \  \   \ \  \\\  \       \ \  \ \  \   \ \  \___|  \ \  \
           \ \_______\      \ \__\   \ \_______\       \ \__\ \__\   \ \__\      \ \__\
            \|_______|       \|__|    \|_______|        \|__|\|__|    \|__|       \|__|'.PHP_EOL.PHP_EOL);

        sleep(1);

        $name = $input->getArgument('name');
        $project = 'projects/'.$name;

        if (! $input->getOption('force')) {
            $this->verifyProjectDoesntExist($project);
        }

        if (file_exists('app') && $input->getOption('force')) {
            (new Filesystem)->remove($project);
        }

        $output->write(PHP_EOL.'  <fg=green>Generating project...</>'.PHP_EOL.PHP_EOL);

        $finder = new Finder();
        $folders = $finder->in(getcwd())
            ->directories()
            ->exclude(['skeleton', 'vendor', 'node_modules', 'projects'])
            ->depth(0)
            ->getIterator();

        $files = [
            ".editorconfig",
            ".env.example",
            ".gitignore",
            "artisan",
            "composer.json",
            "composer.lock",
            "phpunit.xml",
            "phpstan.neon",
            "README-example.md",
            "pint.json",
        ];

        (new Filesystem)->mkdir($project);

        $output->write(PHP_EOL.'  <fg=white>Copying Laravel folders...</>'.PHP_EOL.PHP_EOL);

        foreach ($folders as $folder) {
            (new Filesystem)->mirror(
                originDir: $folder->getRelativePathname(),
                targetDir: $project.'/'.$folder->getRelativePathname(),
                options: ['override' => true]
            );
        }

        $output->write(PHP_EOL.'  <fg=white>Copying Laravel files...</>'.PHP_EOL.PHP_EOL);
        foreach ($files as $file) {
            (new Filesystem)->copy(__DIR__.'/../../'.$file, $project.'/'.$file);
        }

        (new Filesystem)->rename($project.'/README-example.md', $project.'/README.md');

        $output->writeln('  <bg=blue;fg=white> INFO 🚀 </> Skeleton API is ready! <options=bold>Build amazing Laravel API.</>'.PHP_EOL);

        return Command::SUCCESS;
    }

    protected function verifyProjectDoesntExist($project): void
    {
        if ((is_dir($project) || is_file($project)) && $project != getcwd().$project) {
            throw new RuntimeException('Project already exists!');
        }
    }
}
