<?php
namespace App\Console;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends BaseCommand
{
    protected function configure()
    {
        $this->setName('app:academy')
            ->setDescription('Returns academic year by given date')
            ->addOption('data', 'd', InputOption::VALUE_OPTIONAL, 'Path to datafile', 'example.json');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getOption('data');
        $stream = @fopen($filename, 'r');
        if($stream === false){
            $output->writeln('Error opening file!');
            die;
        }
        $data = fread($stream, filesize($filename));
        $output->writeln($data);
    }
}