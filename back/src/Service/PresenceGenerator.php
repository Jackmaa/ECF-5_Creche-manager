<?php
namespace App\Service;

use App\Entity\Presence;
use App\Repository\TypicalWeekRepository;
use Doctrine\ORM\EntityManagerInterface;

class PresenceGeneratorService {
    public function __construct(
        private TypicalWeekRepository $weekRepo,
        private EntityManagerInterface $em
    ) {}

    public function generateWeekPresences(): array {
        $start     = new \DateTime('monday this week');
        $generated = [];

        for ($i = 0; $i < 7; $i++) {
            $date   = $start->modify("+$i days");
            $dayKey = strtolower($date->format('D')); // mon, tue, ...

            $weeks = $this->weekRepo->findAll();

            foreach ($weeks as $week) {
                $planning = $week->getPlanning();
                $child    = $week->getChild();

                if (! isset($planning[$dayKey]) || $planning[$dayKey] === null) {
                    continue;
                }

                $entry = $planning[$dayKey];

                $presence = new Presence();
                $presence->setChild($child);
                $presence->setDate($date);
                $presence->setCheckInTime(new \DateTime($entry['checkIn']));
                $presence->setCheckOutTime(new \DateTime($entry['checkOut']));

                $this->em->persist($presence);
                $generated[] = $presence;
            }
        }

        $this->em->flush();

        return $generated;
    }

}
