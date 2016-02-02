<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VendorSchedule
 *
 * @ORM\Table(name="vendor_schedule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VendorScheduleRepository")
 */
class VendorSchedule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="weekday", type="integer")
     */
    private $weekday;

    /**
     * @var bool
     *
     * @ORM\Column(name="all_day", type="boolean")
     */
    private $allDay;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_hour", type="time")
     */
    private $startHour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stop_hour", type="time")
     */
    private $stopHour;

    /**
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    private $vendor;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set weekday
     *
     * @param integer $weekday
     *
     * @return VendorSchedule
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;

        return $this;
    }

    /**
     * Get weekday
     *
     * @return int
     */
    public function getWeekday()
    {
        return $this->weekday;
    }

    /**
     * Set allDay
     *
     * @param boolean $allDay
     *
     * @return VendorSchedule
     */
    public function setAllDay($allDay)
    {
        $this->allDay = $allDay;

        return $this;
    }

    /**
     * Get allDay
     *
     * @return bool
     */
    public function getAllDay()
    {
        return $this->allDay;
    }

    /**
     * Set startHour
     *
     * @param \DateTime $startHour
     *
     * @return VendorSchedule
     */
    public function setStartHour($startHour)
    {
        $this->startHour = $startHour;

        return $this;
    }

    /**
     * Get startHour
     *
     * @return \DateTime
     */
    public function getStartHour()
    {
        return $this->startHour;
    }

    /**
     * Set stopHour
     *
     * @param \DateTime $stopHour
     *
     * @return VendorSchedule
     */
    public function setStopHour($stopHour)
    {
        $this->stopHour = $stopHour;

        return $this;
    }

    /**
     * Get stopHour
     *
     * @return \DateTime
     */
    public function getStopHour()
    {
        return $this->stopHour;
    }

    /**
     * Set vendor
     *
     * @param \AppBundle\Entity\Vendor $vendor
     *
     * @return VendorSchedule
     */
    public function setVendor(\AppBundle\Entity\Vendor $vendor = null)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return \AppBundle\Entity\Vendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }
}
