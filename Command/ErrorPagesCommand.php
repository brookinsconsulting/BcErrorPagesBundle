<?php
/**
 * File containing the ErrorPagesCommand class part of the BcErrorPagesBundle package.
 *
 * @copyright Copyright (C) Brookins Consulting. All rights reserved.
 * @license For full copyright and license information view LICENSE and COPYRIGHT.md file distributed with this source code.
 * @version //autogentag//
 */

namespace BrookinsConsulting\BcErrorPagesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ErrorPagesCommand extends ContainerAwareCommand
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var bool
     */
    protected $relative;

    /**
     * @var bool
     */
    protected $absolute;

    /**
     * @var bool
     */
    protected $copy;

    /**
     * Configure hourly invoice document creation command line options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('bc:ep:install')
            ->setDescription('Install Error Pages Templates Symlinks')
            ->addOption(
                'path',
                null,
                InputOption::VALUE_OPTIONAL,
                "The string of the path to the target directory. Optional. Defaults to 'app/Resources''",
                'app/Resources'
            )
            ->addOption(
                'relative',
                null,
                InputOption::VALUE_NONE,
                'The flag which determines the use of relative symlinks. Optional. Defaults to true'
            )
            ->addOption(
                'absolute',
                null,
                InputOption::VALUE_NONE,
                'The flag which determines the use of absolute symlinks. Optional. Defaults to false'
            )
            ->addOption(
                'copy',
                null,
                InputOption::VALUE_NONE,
                'The flag which determines the uses copies instead of symlinks. Optional. Defaults to false'
            );
    }

    /**
     * Execute command
     *
     * @param Symfony\Component\Console\Input\InputInterface $input
     * @param Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        // Set Object Properties
        $this->setProperties($input);

        // Install Error Pages Template Symlink
        $this->install($output);
    }

    /**
     * Set commandline parameters as object properties
     *
     * @param Symfony\Component\Console\Input\InputInterface $input
     * @return void
     */
    protected function setProperties(
        InputInterface $input
    ) {
        $this->path = $input->getOption('path') . '/TwigBundle';

        // Detect installation method: relative, absolute, copy
        if($this->relative === true && $this->absolute === true) {
            $this->copy = false;
        } else {
            $this->copy = $input->getOption('copy');
        }

        if($this->relative === true && $this->copy === true) {
            $this->absolute = false;
        } else {
            $this->absolute = $input->getOption('absolute');
        }

        if($this->absolute === true && $this->copy === true) {
            $this->relative = false;
        } else {
            $this->relative = $input->getOption('relative');
        }
    }

    /**
     * Search for GitHub repositories with stars
     *
     * @param Symfony\Component\Console\Output\OutputInterface $output
     * @return bool
     */
    public function install(
        OutputInterface $output
    ) {
        // Get filesystem object
        $fs = new Filesystem();
        $result = false;

        // Test if designation path already exists
        if ($fs->exists($this->path))
        {
            $output->writeln("Failure! Destination path already exists. Template copies or symlinks -not- installed");
        } else {
            // Install templates
            if ($this->relative) {
                $output->writeln("Installing using relative symlink");
                try {
                    $fs->symlink('vendor/brookinsconsulting/bcerrorpagesbundle/Resources/TwigBundle', $this->path, true);
                    $output->writeln("Success! Relative symlink installed");
                    $result = true;
                } catch (IOExceptionInterface $e) {
                    $output->writeln("An error occurred while creating the relative symlink at ".$e->getPath());
                }
            } elseif ($this->absolute) {
                $output->writeln("Installing using absolute symlink");
                try {
                    $fs->symlink('vendor/brookinsconsulting/bcerrorpagesbundle/Resources/TwigBundle', $this->path, true);
                    $output->writeln("Success! Absolute symlink installed");
                    $result = true;
                } catch (IOExceptionInterface $e) {
                    $output->writeln("An error occurred while creating the absolute symlink at ".$e->getPath());
                }
            } elseif ($this->copy) {
                $output->writeln("Installing using copies of templates");
                try {
                    $fs->mirror('vendor/brookinsconsulting/bcerrorpagesbundle/Resources/TwigBundle', $this->path, array( 'override' => true, 'copyonwindows' => true ));
                    $output->writeln("Success! Template copies installed");
                    $result = true;
                } catch (IOExceptionInterface $e) {
                    $output->writeln("An error occurred while creating the directory at ".$e->getPath());
                }
            }
        }

        // Display failure results to cli buffer
        if ($result === false) {
            $output->writeln("Failure! Template copies or symlinks -not- installed");
        }

        return $result;
    }
}