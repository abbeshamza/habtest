<?php

/**
 * This file defines the shell command
 *
 * @category AppBundle
 * @package Core
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace AppBundle\Core;


use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

/**
 *  Class CmdShell
 *
 * @category AppBundle
 * @package Core
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
class CmdShell

{
    /**
     * @var Filesystem Attribute
     */
    protected $fs;
    /**
     * @var object  Container
     */
    protected $container;

    /**
     * CmdShell constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->fs= new Filesystem();
    }

    /**
     * Unzip a specific zip file to a specific folder
     * @param $file
     * @param $folder
     */
    public function unzipCmd($file , $folder)
    {
        $process = new Process('unzip '.$file.' -d '.$folder);
        $process->run();
        $process->wait();

    }

    /**
     * Delete a folder or file with or without option
     * @param $file
     * @param null $option
     */
    public function delete($file , $option = null)
    {
        $process = new Process('rm '.$option.' '.$file);
        $process->run();
        $process->wait();

    }

    /**
     * Copy a folder or a file
     * @param string $from
     * @param string $destination
     */
    public function copy( $from, $destination )
    {
        $this->fs->copy($from,$destination);
    }

    /**
     * Create a folder
     * @param string $name
     * @param string $path
     */
    public function createFolder( $name,  $path )
    {
        $this->fs->mkdir($path.'/'.$name);
    }

    /**
     * Move or rename a directory
     * @param $from
     * @param $destination
     */
    public function mouveDirectory($from, $destination)
    {
        $process = new Process('mv  '.$from.'  '.$destination);
        $process->run();
        $process->wait();

    }

    /**
     * Scan a specific directory
     * @param $path
     * @return string
     */
    public function scanDirectory($path)
    {
        $process = new Process('ls '.$path);
        $process->run();
        $process->wait();
        return $process->getOutput();

    }


    /**
     *
     * Run codeception tests for a specific folder
     * @param $tests
     * @param $path
     */
    public function runCodeception($tests , $path)
    {
        $process = new Process('cd .. ;php bin/codecept run '.$tests.'  '.$path);
        $process->setTimeout(300 * 600);
        $process->run();
        $process->wait();

    }

}