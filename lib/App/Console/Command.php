<?php
namespace App\Console;

use App\Service\EntityFactory;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends BaseCommand
{
    protected function configure()
    {
        $this->setName('app:academy')
             ->setDescription('Returns academic year by given date')
             ->addOption('filename', 'f', InputOption::VALUE_OPTIONAL, 'Path to datafile', 'example.json')
             ->addArgument('data', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getOption('filename');
        $stream = @fopen($filename, 'r');
        if ($stream === false) {
            $output->writeln('Error opening file!');
            die;
        }
        $data = fread($stream, filesize($filename));
        $data = json_decode($data, true);
        $factory = new EntityFactory($data['format']);
        try {
            $years = $factory->createFromData($data['data']);
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            die;
        }
        $givenDate = $input->getArgument('data');
        $givenDate = \DateTime::createFromFormat($data['format'], $givenDate);
        if (!$givenDate) {
            $output->writeln('Incorrect argument');
            die;
        }

        foreach ($years as $year) {
            if ($year->belongs($givenDate)) {
                $output->writeln($year->getName());
                $term = $year->getTerm($givenDate);
                if ($term) {
                    $output->writeln(sprintf('%s(\'%s\' - \'%s\') - %s days',
                        $term->getName(),
                        $term->getStartDate()
                             ->format('Y-m-d'),
                        $term->getStopDate()
                             ->format('Y-m-d'),
                        $term->getLength()->format('%a')));
                }
            }
        }
    }
}