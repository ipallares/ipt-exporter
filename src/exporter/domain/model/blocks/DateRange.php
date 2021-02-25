<?php

declare(strict_types=1);

namespace App\exporter\domain\model\blocks;

use App\exporter\domain\exceptions\IniDateAfterEndDateException;
use DateTime;
use Exception;

class DateRange
{
    private const DATE_FORMAT = 'd-m-Y';

    private DateTime $iniDate;
    private DateTime $endDate;

    /**
     * @throws IniDateAfterEndDateException
     * @throws Exception
     */
    private function __construct(DateTime $iniDate, DateTime $endDate)
    {
        if ($endDate->getTimestamp() < $iniDate->getTimestamp()) {
           throw new IniDateAfterEndDateException();
        }

        $this->iniDate = $iniDate;
        $this->endDate = $endDate;
    }

    /**
     * @throws Exception
     */
    public static function fromTimestamps(int $iniTimestamp, int $endTimestamp): DateRange
    {
        return new self(
            self::getDateTimeFromTimestamp($iniTimestamp),
            self::getDateTimeFromTimestamp($endTimestamp)
        );
    }

    /**
     * @throws Exception
     */
    public static function fromDateTimes(DateTime $iniDate, DateTime $endDate): DateRange
    {
        return new self($iniDate, $endDate);
    }

    /**
     * @throws Exception
     */
    public static function fromStrings(string $iniTime, string $endTime): DateRange
    {
        return new self(new DateTime($iniTime), new DateTime($endTime));
    }

    public function export()
    {
        return '<daterange>' . $this->formatDateTime($this->iniDate) .  ' - '
                    . $this->formatDateTime($this->endDate) . '</daterange>';
    }

    public function getIniDate(): DateTime
    {
        return $this->iniDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    private static function getDateTimeFromTimestamp(int $timestamp): DateTime
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp);

        return $dateTime;
    }

    private function formatDateTime(DateTime $dateTime): string
    {
        return $dateTime->format(self::DATE_FORMAT);
    }
}
