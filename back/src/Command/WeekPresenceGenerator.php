<?php
namespace App\Command;

use App\Service\PresenceGeneratorService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'creche:generate-week',
    description: 'Génère les présences pour la semaine à venir à partir des semaines types',
)]
class GenerateWeekPresencesCommand extends Command {
    public function __construct(private readonly PresenceGeneratorService $generator) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);
        $io->title('Génération automatique des présences de la semaine');

        $presences = $this->generator->generateWeekPresences();

        $io->success(count($presences) . ' présences générées avec succès.');
        return Command::SUCCESS;
    }
}
