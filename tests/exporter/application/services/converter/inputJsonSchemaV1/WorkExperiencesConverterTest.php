<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\converter\inputJsonSchemaV1;

use App\exporter\application\services\converter\inputJsonSchemaV1\jsonToCvPartConverters\WorkExperiencesConverter;
use App\exporter\domain\model\blocks\DateRange;
use App\exporter\domain\model\blocks\WorkExperience;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WorkExperiencesConverterTest extends KernelTestCase
{
    private WorkExperiencesConverter $converter;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->converter = self::$kernel->getContainer()->get(WorkExperiencesConverter::class);
    }

    /**
     * @throws Exception
     */
    public function testConversion(): void
    {
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $jsonObject = json_decode($inputJson);

        $workExperiences = $this->converter->convert($jsonObject);
        $this->assertCount(2, $workExperiences->getWorkExperiences());

        /** @var WorkExperience $workExperience1 */
        $workExperience1 = $workExperiences->getWorkExperiences()[0];
        $expectedWorkExperience1 = $jsonObject->workExperiences[0];
        $this->assertEquals($expectedWorkExperience1->companyName, $workExperience1->getCompanyName());
        $this->assertEquals($expectedWorkExperience1->position, $workExperience1->getPosition());
        $this->assertEquals($expectedWorkExperience1->description, $workExperience1->getTasksDescription());

        $dateRange = $workExperience1->getDateRange();
        $expectedDateRange = DateRange::fromStrings($expectedWorkExperience1->startDate, $expectedWorkExperience1->endDate);
        $this->assertEquals($dateRange->getIniDate()->format('d-m-Y'), $expectedDateRange->getIniDate()->format('d-m-Y'));
        $this->assertEquals($dateRange->getEndDate()->format('d-m-Y'), $expectedDateRange->getEndDate()->format('d-m-Y'));

        /** @var WorkExperience $workExperience2 */
        $workExperience2 = $workExperiences->getWorkExperiences()[1];
        $expectedWorkExperience2 = $jsonObject->workExperiences[1];
        $this->assertEquals($expectedWorkExperience2->companyName, $workExperience2->getCompanyName());
        $this->assertEquals($expectedWorkExperience2->position, $workExperience2->getPosition());
        $this->assertEquals($expectedWorkExperience2->description, $workExperience2->getTasksDescription());

        $dateRange = $workExperience2->getDateRange();
        $expectedDateRange = DateRange::fromStrings($expectedWorkExperience2->startDate, $expectedWorkExperience2->endDate);
        $this->assertEquals($dateRange->getIniDate()->format('d-m-Y'), $expectedDateRange->getIniDate()->format('d-m-Y'));
        $this->assertEquals($dateRange->getEndDate()->format('d-m-Y'), $expectedDateRange->getEndDate()->format('d-m-Y'));
    }
}
