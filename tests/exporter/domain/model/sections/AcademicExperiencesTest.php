<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\sections;

use App\exporter\domain\model\blocks\AcademicExperience;
use App\exporter\domain\model\blocks\DateRange;
use App\exporter\domain\model\sections\AcademicExperiences;
use App\Tests\exporter\domain\model\interfaces\MultipleContentLengthExportTestInterface;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AcademicExperiencesTest extends TestCase implements MultipleContentLengthExportTestInterface
{
    /**
     * @throws Exception
     */
    public function testWrongConstructorParameters(): void
    {
        $dateRange = DateRange::fromTimestamps(time(), time() + 999999);
        $academicExperience1 = new AcademicExperience('school name 1', 'title 1', $dateRange, 'description 1');
        $academicExperience2 = new AcademicExperience('school name 2', 'title 2', $dateRange, 'description 2');
        $academicExperiencesArray = [$academicExperience1, 13, $academicExperience2];

        $this->expectException(InvalidArgumentException::class);
        new AcademicExperiences($academicExperiencesArray);
    }

    /**
     * @throws Exception
     */
    public function testCompressedExport(): void
    {
        $expectedCompressedAcademicExperiencesExport = '<compressed-academicexperiences><compressed-academicexperience><daterange>24-02-2020 - 24-03-2020</daterange><schoolname>school name 1</schoolname><title>title 1</title></compressed-academicexperience><compressed-academicexperience><daterange>24-02-2020 - 24-03-2020</daterange><schoolname>school name 2</schoolname><title>title 2</title></compressed-academicexperience><compressed-academicexperiences>';
        $dateRange = DateRange::fromTimestamps(strtotime("24-02-2020"), strtotime('24-03-2020'));
        $academicExperience1 = new AcademicExperience('school name 1', 'title 1', $dateRange, 'additional info 1');
        $academicExperience2 = new AcademicExperience('school name 2', 'title 2', $dateRange, 'additional info 2');

        $academicExperiences = new AcademicExperiences([$academicExperience1, $academicExperience2]);
        $compressedAcademicExperiencesExport = $academicExperiences->exportCompressed();

        $this->assertEquals($expectedCompressedAcademicExperiencesExport, $compressedAcademicExperiencesExport);
    }

    /**
     * @throws Exception
     */
    public function testExtendedExport(): void
    {
        $expectedExtendedAcademicExperiencesExport = '<extended-academicexperiences><extended-academicexperience><daterange>24-02-2020 - 24-03-2020</daterange><schoolname>school name 1</schoolname><title>title 1</title><additionalinfo>additional info 1</additionalinfo></extended-academicexperience><extended-academicexperience><daterange>24-02-2020 - 24-03-2020</daterange><schoolname>school name 2</schoolname><title>title 2</title><additionalinfo>additional info 2</additionalinfo></extended-academicexperience><extended-academicexperiences>';
        $dateRange = DateRange::fromTimestamps(strtotime("24-02-2020"), strtotime('24-03-2020'));
        $academicExperience1 = new AcademicExperience('school name 1', 'title 1', $dateRange, 'additional info 1');
        $academicExperience2 = new AcademicExperience('school name 2', 'title 2', $dateRange, 'additional info 2');

        $academicExperiences = new AcademicExperiences([$academicExperience1, $academicExperience2]);
        $extendedAcademicExperiencesExport = $academicExperiences->exportExtended();

        $this->assertEquals($expectedExtendedAcademicExperiencesExport, $extendedAcademicExperiencesExport);
    }
}
