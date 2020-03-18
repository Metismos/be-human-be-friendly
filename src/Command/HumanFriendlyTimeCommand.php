<?php

namespace App\Command;

use App\Service\TimeTransformerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HumanFriendlyTimeCommand extends Command
{
    protected static $defaultName = 'app:human-friendly-time';

    /**
     * @var TimeTransformerInterface
     */
    protected $timeTransformer;

    public function __construct(TimeTransformerInterface $timeTransformer)
    {
        $this->timeTransformer = $timeTransformer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Gives a human friendly time (either current or from a passed value)')
            ->addArgument('time', InputArgument::OPTIONAL, 'Time to friendlify')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $time = $input->getArgument('time');

        if ($time) {
            $io->note(sprintf('You passed the time: %s', $time));
        }
        
        $humanFriendlyTime = $this->timeTransformer->getTime($time);

        if (!$humanFriendlyTime) {
            $io->error('We could not transform your time into a human friendly format.');
        } else {
            $io->success($humanFriendlyTime);
        }

        return 0;
    }
}
