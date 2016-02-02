<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vendor
 *
 * @ORM\Table(name="vendor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VendorRepository")
 */
class Vendor
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="VendorSchedule", mappedBy="vendor")
     */
    private $vendorSchedules;

    /**
     * @ORM\OneToMany(targetEntity="VendorSpecialDay", mappedBy="vendor")
     */
    private $vendorSpecialDays;

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
     * Set name
     *
     * @param string $name
     *
     * @return Vendor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vendorSchedules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vendorSpecialDays = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add vendorSchedule
     *
     * @param \AppBundle\Entity\VendorSchedule $vendorSchedule
     *
     * @return Vendor
     */
    public function addVendorSchedule(\AppBundle\Entity\VendorSchedule $vendorSchedule)
    {
        $this->vendorSchedules[] = $vendorSchedule;

        return $this;
    }

    /**
     * Remove vendorSchedule
     *
     * @param \AppBundle\Entity\VendorSchedule $vendorSchedule
     */
    public function removeVendorSchedule(\AppBundle\Entity\VendorSchedule $vendorSchedule)
    {
        $this->vendorSchedules->removeElement($vendorSchedule);
    }

    /**
     * Get vendorSchedules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVendorSchedules()
    {
        return $this->vendorSchedules;
    }

    /**
     * Add vendorSpecialDay
     *
     * @param \AppBundle\Entity\VendorSpecialDay $vendorSpecialDay
     *
     * @return Vendor
     */
    public function addVendorSpecialDay(\AppBundle\Entity\VendorSpecialDay $vendorSpecialDay)
    {
        $this->vendorSpecialDays[] = $vendorSpecialDay;

        return $this;
    }

    /**
     * Remove vendorSpecialDay
     *
     * @param \AppBundle\Entity\VendorSpecialDay $vendorSpecialDay
     */
    public function removeVendorSpecialDay(\AppBundle\Entity\VendorSpecialDay $vendorSpecialDay)
    {
        $this->vendorSpecialDays->removeElement($vendorSpecialDay);
    }

    /**
     * Get vendorSpecialDays
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVendorSpecialDays()
    {
        return $this->vendorSpecialDays;
    }
}
