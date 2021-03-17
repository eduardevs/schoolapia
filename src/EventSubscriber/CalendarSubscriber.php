<?php

namespace App\EventSubscriber;

use App\Entity\Horaire;
use App\Repository\ClasseRepository;
use App\Repository\HoraireRepository;
use App\Repository\MatiereRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{   
    /** @var Repository */
    private $horaireRepository;
    private $classeRepository;
    private $router;
    private $matiereRepository;

    public function __construct(HoraireRepository $horaireRepository, UrlGeneratorInterface $router, ClasseRepository $classeRepository, MatiereRepository $matiereRepository){
        $this->horaireRepository = $horaireRepository;
        $this->router = $router;
        $this->classeRepository = $classeRepository;
        $this->matiereRepository = $matiereRepository;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $filters = $calendar->getFilters();
        $id = $filters['id'];
        // Par classe
        $req = $this->classeRepository
            ->createQueryBuilder('classe')
            ->where('classe.id = :id ')
            ->setParameter('id', $id)
            // ->setParameter('horaireFin', $end->format('d-m-Y H:i:s'))
            ->getQuery()
            ->getResult();
        $classe = $req[0];
        $emploiDuTemps = $classe->getEmploiDuTemps();
        foreach($emploiDuTemps->getMatieres() as $matiere){
            foreach($matiere->getHoraire() as $horaire){
                $d = date_format($horaire->getJour(), 'Y-m-d');
                $hd = date_format($horaire->getHeureDebut(), 'H:i:s');
                $hf = date_format($horaire->getHeureFin(), 'H:i:s');
                //
                $horaireEvent = new Event(
                    $matiere->getNomMatiere(),
                    new \DateTime($d.' '.$hd),
                    new \DateTime($d.' '.$hf),
                );
                //
                $bg = $this->matiereRepository->getBackgroundColor();
                $bc = $this->matiereRepository->getBorderColor();
                $tc = $this->matiereRepository->getTextColor();
                $horaireEvent->setOptions(['backgroundColor'=>$bg, 'borderColor'=>$bc, 'textColor'=>$tc]);
                // $horaireEvent->addOption('url', $this->router->generate('horaire_show', ['id'=> $horaire->getId(),]));
                $calendar->addEvent($horaireEvent);
            }
        }
    }
}