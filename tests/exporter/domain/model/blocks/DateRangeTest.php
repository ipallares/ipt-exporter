<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\blocks;

use App\exporter\domain\Exceptions\IniDateAfterEndDateException;
use App\exporter\domain\model\blocks\DateRange;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testInvalidDateRange()
    {
        $currentTimestamp = time();
        $previousTimestamp = $currentTimestamp - 1000000;

        $this->expectException(IniDateAfterEndDateException::class);
        DateRange::fromTimestamps($currentTimestamp, $previousTimestamp);
    }

    /**
     * @throws Exception
     */
    public function testExportDateRange(): void
    {
        $expectedExportDateRange = '<daterange>01-01-2014 - 01-06-2018</daterange>';

        // using fromDateTimes named constructor
        $dateRange = DateRange::fromDateTimes(new DateTime('01-01-2014'), new DateTime('01-06-2018'));
        $exportedDateRange = $dateRange->export();
        $this->assertEquals($expectedExportDateRange, $exportedDateRange);

        // using fromTimestamps named constructor
        $dateRange = DateRange::fromTimestamps(strtotime('01-01-2014'), strtotime('01-06-2018'));
        $exportedDateRange = $dateRange->export();
        $this->assertEquals($expectedExportDateRange, $exportedDateRange);

        // using fromStrings named constructor
        $dateRange = DateRange::fromStrings('01-01-2014', '01-06-2018');
        $exportedDateRange = $dateRange->export();
        $this->assertEquals($expectedExportDateRange, $exportedDateRange);
    }
}
