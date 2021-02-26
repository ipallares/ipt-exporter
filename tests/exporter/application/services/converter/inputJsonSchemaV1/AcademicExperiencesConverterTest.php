<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\converter\inputJsonSchemaV1;

use App\exporter\application\services\converter\inputJsonSchemaV1\jsonToCvPartConverters\AcademicExperiencesConverter;
use App\exporter\domain\model\blocks\AcademicExperience;
use App\exporter\domain\model\blocks\DateRange;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AcademicExperiencesConverterTest extends KernelTestCase
{
    private AcademicExperiencesConverter $converter;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->converter = self::$kernel->getContainer()->get(AcademicExperiencesConverter::class);
    }

    /**
     * @throws Exception
     */
    public function testConversion(): void
    {
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $jsonObject = json_decode($inputJson);

        $cv = $this->converter->convert($jsonObject);
        $this->assertCount(2, $cv->getAcademicExperiences());

        /** @var AcademicExperience $academicExperience1 */
        $academicExperience1 = $cv->getAcademicExperiences()[0];
        $expectedAcademicExperience1 = $jsonObject->academicExperiences[0];
        $this->assertEquals($expectedAcademicExperience1->schoolName, $academicExperience1->getSchoolName());
        $this->assertEquals($expectedAcademicExperience1->title, $academicExperience1->getTitle());
        $this->assertEquals($expectedAcademicExperience1->description, $academicExperience1->getAdditionalInfo());

        $dateRange = $academicExperience1->getDateRange();
        $expectedDateRange = DateRange::fromStrings($expectedAcademicExperience1->startDate, $expectedAcademicExperience1->endDate);
        $this->assertEquals($dateRange->getIniDate()->format('d-m-Y'), $expectedDateRange->getIniDate()->format('d-m-Y'));
        $this->assertEquals($dateRange->getEndDate()->format('d-m-Y'), $expectedDateRange->getEndDate()->format('d-m-Y'));

        /** @var AcademicExperience $academicExperience2 */
        $academicExperience2 = $cv->getAcademicExperiences()[1];
        $expectedAcademicExperience2 = $jsonObject->academicExperiences[1];
        $this->assertEquals($expectedAcademicExperience2->schoolName, $academicExperience2->getSchoolName());
        $this->assertEquals($expectedAcademicExperience2->title, $academicExperience2->getTitle());
        $this->assertEquals($expectedAcademicExperience2->description, $academicExperience2->getAdditionalInfo());

        $dateRange = $academicExperience2->getDateRange();
        $expectedDateRange = DateRange::fromStrings($expectedAcademicExperience2->startDate, $expectedAcademicExperience2->endDate);
        $this->assertEquals($dateRange->getIniDate()->format('d-m-Y'), $expectedDateRange->getIniDate()->format('d-m-Y'));
        $this->assertEquals($dateRange->getEndDate()->format('d-m-Y'), $expectedDateRange->getEndDate()->format('d-m-Y'));
    }
}
