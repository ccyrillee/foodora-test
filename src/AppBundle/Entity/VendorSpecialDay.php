<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VendorSpecialDay
 *
 * @ORM\Table(name="vendor_special_day")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VendorSpecialDayRepository")
 */
class VendorSpecialDay
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
     * @var \DateTime
     *
     * @ORM\Column(name="special_date", type="date")
     */
    private $specialDate;

    /**
     * @var string
     *
     * @ORM\Column(name="event_type", type="string", length=255)
     */
    private $eventType;

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

    const FORMAT_SPECIAL_DATE = 'Y-m-d';
    const CLOSED = 'closed';
    const OPENED = 'opened';

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
     * Set specialDate
     *
     * @param \DateTime $specialDate
     *
     * @return VendorSpecialDay
     */
    public function setSpecialDate($specialDate)
    {
        $this->specialDate = $specialDate;

        return $this;
    }

    /**
     * Get specialDate
     *
     * @return \DateTime
     */
    public function getSpecialDate()
    {
        return $this->specialDate;
    }

    /**
     * Set eventType
     *
     * @param string $eventType
     *
     * @return VendorSpecialDay
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set allDay
     *
     * @param boolean $allDay
     *
     * @return VendorSpecialDay
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
     * @return VendorSpecialDay
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
     * @param string $stopHour
     *
     * @return VendorSpecialDay
     */
    public function setStopHour($stopHour)
    {
        $this->stopHour = $stopHour;

        return $this;
    }

    /**
     * Get stopHour
     *
     * @return string
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
     * @return VendorSpecialDay
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
