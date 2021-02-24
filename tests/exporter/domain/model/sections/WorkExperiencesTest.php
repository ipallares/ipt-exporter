<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\sections;

use App\exporter\domain\model\blocks\DateRange;
use App\exporter\domain\model\blocks\WorkExperience;
use App\exporter\domain\model\sections\WorkExperiences;
use App\Tests\exporter\domain\model\interfaces\MultipleContentLengthExportTestInterface;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class WorkExperiencesTest extends TestCase implements MultipleContentLengthExportTestInterface
{
    /**
     * @throws Exception
     */
    public function testWrongConstructorParameters(): void
    {
        $dateRange = DateRange::fromTimestamps(time(), time() + 999999);
        $workExperience1 = new WorkExperience('school name 1', 'title 1', $dateRange, 'description 1');
        $workExperience2 = new WorkExperience('school name 2', 'title 2', $dateRange, 'description 2');
        $workExperiencesArray = [$workExperience1, 13, $workExperience2];

        $this->expectException(InvalidArgumentException::class);
        new WorkExperiences($workExperiencesArray);
    }

    /**
     * @throws Exception
     */
    public function testCompressedExport(): void
    {
        $expectedCompressedWorkExperiencesExport = '<compressed-workexperiences><compressed-workexperience><daterange>24-02-2020 - 24-03-2020</daterange><companyname>company name 1</companyname><position>job position 1</position></compressed-workexperience><compressed-workexperience><daterange>24-02-2020 - 24-03-2020</daterange><companyname>company name 2</companyname><position>job position 2</position></compressed-workexperience><compressed-workexperiences>';
        $dateRange = DateRange::fromTimestamps(strtotime("24-02-2020"), strtotime('24-03-2020'));
        $workExperience1 = new WorkExperience('company name 1', 'job position 1', $dateRange, 'task description 1');
        $workExperience2 = new WorkExperience('company name 2', 'job position 2', $dateRange, 'task description 2');

        $workExperiences = new WorkExperiences([$workExperience1, $workExperience2]);
        $compressedWorkExperiencesExport = $workExperiences->exportCompressed();

        $this->assertEquals($expectedCompressedWorkExperiencesExport, $compressedWorkExperiencesExport);
    }

    /**
     * @throws Exception
     */
    public function testExtendedExport(): void
    {
        $expectedExtendedWorkExperiencesExport = '<extended-workexperiences><extended-workexperience><daterange>24-02-2020 - 24-03-2020</daterange><companyname>company name 1</companyname><position>job position 1</position><taskdescription>task description 1</taskdescription></extended-workexperience><extended-workexperience><daterange>24-02-2020 - 24-03-2020</daterange><companyname>company name 2</companyname><position>job position 2</position><taskdescription>task description 2</taskdescription></extended-workexperience><extended-workexperiences>';
        $dateRange = DateRange::fromTimestamps(strtotime("24-02-2020"), strtotime('24-03-2020'));
        $workExperience1 = new WorkExperience('company name 1', 'job position 1', $dateRange, 'task description 1');
        $workExperience2 = new WorkExperience('company name 2', 'job position 2', $dateRange, 'task description 2');

        $workExperiences = new WorkExperiences([$workExperience1, $workExperience2]);
        $extendedWorkExperiencesExport = $workExperiences->exportExtended();

        $this->assertEquals($expectedExtendedWorkExperiencesExport, $extendedWorkExperiencesExport);
    }
}
