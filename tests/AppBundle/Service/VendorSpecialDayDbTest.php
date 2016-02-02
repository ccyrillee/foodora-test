<?php

namespace AppBundle\Service\Db;

use AppBundle\Entity\Vendor;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VendorSpecialDayTest extends KernelTestCase
{
    private $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }

    protected function getVendor1() {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        /** @var Vendor $vendor */
        $vendor = $em->getRepository('AppBundle:Vendor')->find(1);
        return $vendor;
    }

    public function testDbVendorSpecialDay1() {
        $db = $this->container->get('app.db.vendor_special_day');
        $specialDayRequiredToBeUpdated = $db->getDaysInRange($this->getVendor1(), '2015-12-24', '2015-12-25');

        $this->assertTrue(count($specialDayRequiredToBeUpdated) == 2);
    }

    public function testDbVendorSpecialDay2() {
        $db = $this->container->get('app.db.vendor_special_day');
        $specialDayRequiredToBeUpdated = $db->getDaysInRange($this->getVendor1(), '2015-12-24', '2015-12-27');

        $this->assertTrue(count($specialDayRequiredToBeUpdated) == 4);
    }

    public function testDbVendorSpecialDay3() {
        $db = $this->container->get('app.db.vendor_special_day');
        $specialDayRequiredToBeUpdated = $db->getDaysInRange($this->getVendor1(), '2015-11-24', '2015-11-27');

        $this->assertTrue(count($specialDayRequiredToBeUpdated) == 0);
    }
}