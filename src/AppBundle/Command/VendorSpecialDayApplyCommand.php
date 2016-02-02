<?php


namespace AppBundle\Command;

use AppBundle\Entity\Vendor;
use AppBundle\Entity\VendorSchedule;
use AppBundle\Entity\VendorSpecialDay;
use AppBundle\Service\Db\VendorScheduleDb;
use AppBundle\Service\Db\VendorSpecialDayDb;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class VendorSpecialDayApplyCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('foodora:apply-vendor-special-day')
            ->setDescription('Apply temporary changes in the DB for solve the problem with vendor special days');
    }

    /**
     * @var OutputInterface
     */
    protected $output = null;

    protected $collectSql = [];

    /**
     * Executes the current command.
     *
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return integer 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract class is not implemented
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $this->updateVendors();
    }

    protected function updateVendors()
    {
        $container = $this->getContainer();

        /** @var EntityManager $em */
        $em = $container->get('doctrine.orm.default_entity_manager');

        /** @var Vendor[] $vendors */
        $vendors = $em->getRepository('AppBundle:Vendor')->findAll();
        foreach ($vendors as $vendor) {
            $this->output->writeln('<info>Updating vendor ' . $vendor->getId() . '</info>');
            $this->updateVendor($vendor);
        }
    }

    /**
     * @return array
     */
    protected function getMapping()
    {
        $mapping = ['2015-12-21' => 1, '2015-12-22' => 2, '2015-12-23' => 3, '2015-12-24' => 4, '2015-12-25' => 5,
            '2015-12-26' => 6, '2015-12-27' => 7];
        return $mapping;
    }

    /**
     * @param VendorSchedule[] $schedules
     */
    protected function deleteSchedules($schedules) {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        foreach ($schedules as $schedule) {
            $this->generateRollBackInsert($schedule);
            $em->remove($schedule);
        }
        $em->flush();
    }

    protected function generateRollBackInsert(VendorSchedule $schedule) {
        $id = $schedule->getId();
        $vendorId = $schedule->getVendor()->getId();
        $weekday = $schedule->getWeekday();
        $allDay = $schedule->getAllDay() ? '1' : '0';
        if ($schedule->getStartHour()) {
            $startHour = "'" .$schedule->getStartHour()->format('H:i:s') . "'";
        }
        else {
            $startHour = 'NULL';
        }
        if ($schedule->getStartHour()) {
            $stopHour = "'" . $schedule->getStopHour()->format('H:i:s') . "'";
        }
        else {
            $stopHour = 'NULL';
        }

        $schedule = "INSERT INTO `foodora-test`.`vendor_schedule` (`id` ,`vendor_id` ,`weekday` ,`all_day` ,`start_hour` ,`stop_hour`) VALUES ";
        $schedule .= "($id , '$vendorId', '$weekday', '$allDay', $startHour , $stopHour);";

        $this->collectSql[] = $schedule;
    }

    protected function generateSqlScript() {
        file_put_contents('/tmp/foodora.sql', implode("\n", $this->collectSql));
    }

    protected function flush() {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $em->flush();
    }

    /**
     * @param VendorSpecialDay $specialSchedule
     */
    protected function deleteCurrentSchedule(VendorSpecialDay $specialSchedule)
    {
        $mapping = $this->getMapping();

        $formattedDate = $specialSchedule->getSpecialDate()->format(VendorSpecialDay::FORMAT_SPECIAL_DATE);
        $weekday = $mapping[$formattedDate];

        /** @var VendorScheduleDb $db */
        $db = $this->getContainer()->get('app.db.vendor_schedule');
        /** @var VendorSchedule[] $schedules */
        $schedules = $db->getSchedulesByWeekDay($specialSchedule->getVendor(), $weekday);
        $this->deleteSchedules($schedules);
    }

    /**
     * @param VendorSpecialDay $specialSchedule
     */
    protected function convertSpecialScheduleInNormalSchedule(VendorSpecialDay $specialSchedule)
    {
        $mapping = $this->getMapping();

        $formattedDate = $specialSchedule->getSpecialDate()->format(VendorSpecialDay::FORMAT_SPECIAL_DATE);
        $weekday = $mapping[$formattedDate];

        $normalSchedule = new VendorSchedule();
        $normalSchedule->setAllDay($specialSchedule->getAllDay());
        $normalSchedule->setStartHour($specialSchedule->getStartHour());
        $normalSchedule->setStopHour($specialSchedule->getStopHour());
        $normalSchedule->setWeekday($weekday);
        $normalSchedule->setVendor($specialSchedule->getVendor());

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($normalSchedule);

        $em->flush();

        $id = $normalSchedule->getId();

        $this->collectSql[] = "DELETE FROM `foodora-test`.`vendor_schedule` WHERE `vendor_schedule`.`id` = $id;";
    }

    /**
     * @param Vendor $vendor
     */
    protected function updateVendor(Vendor $vendor)
    {
        /** @var VendorSpecialDayDb $db */
        $db = $this->getContainer()->get('app.db.vendor_special_day');
        /** @var VendorSpecialDay[] $specialSchedules */
        $specialSchedules = $db->getDaysInRange($vendor, '2015-12-21', '2015-12-27');
        $this->output->writeln('Update required for ' . count($specialSchedules) . ' special schedule(s)');

        foreach ($specialSchedules as $specialSchedule) {
            $this->deleteCurrentSchedule($specialSchedule);
        }
        foreach ($specialSchedules as $specialSchedule) {
            $this->convertSpecialScheduleInNormalSchedule($specialSchedule);
        }
        $this->generateSqlScript();
    }

}
