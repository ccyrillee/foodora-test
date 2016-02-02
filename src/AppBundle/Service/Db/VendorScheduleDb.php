<?php

namespace AppBundle\Service\Db;

use AppBundle\Entity\Vendor;
use Doctrine\ORM\EntityManager;
use AppBundle\Repository\VendorScheduleRepository;

class VendorScheduleDb {

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @return VendorScheduleRepository
     */
    protected function getRepository() {
        return $this->em->getRepository('AppBundle:VendorSchedule');
    }

    public function getSchedulesByWeekDay(Vendor $vendor, $weekday) {
        return $this->getRepository()->findBy(['vendor' => $vendor, 'weekday' => $weekday]);
    }
} 