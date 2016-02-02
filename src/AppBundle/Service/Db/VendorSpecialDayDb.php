<?php

namespace AppBundle\Service\Db;

use Doctrine\ORM\EntityManager;
use AppBundle\Repository\VendorSpecialDayRepository;

class VendorSpecialDayDb {

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @return VendorSpecialDayRepository
     */
    protected function getRepository() {
        return $this->em->getRepository('AppBundle:VendorSpecialDay');
    }

    public function getDaysInRange($vendor, $startDate, $stopDate) {
        $repository = $this->getRepository();

        $query = $repository->createQueryBuilder('days')
            ->andWhere('days.vendor = :vendor')
            ->andWhere('days.specialDate >= :startDate')
            ->andWhere('days.specialDate <= :stopDate')
            ->setParameter('vendor', $vendor)
            ->setParameter('startDate', $startDate)
            ->setParameter('stopDate', $stopDate)
            ->getQuery();

        $days = $query->getResult();
        return $days;
    }
} 