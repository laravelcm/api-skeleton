<?php

namespace Skeleton\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

final class UseProject extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('use')
            ->setDescription('Use a project as scaffold for a new Laravel API skeleton')
            ->addArgument('project', InputArgument::REQUIRED, 'The project to use as scaffold');
    }
}
