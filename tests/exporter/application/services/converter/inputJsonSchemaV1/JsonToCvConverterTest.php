<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\converter\inputJsonSchemaV1;

use App\exporter\application\services\converter\inputJsonSchemaV1\JsonToCvConverter;
use App\exporter\domain\model\blocks\AcademicExperience;
use App\exporter\domain\model\blocks\WorkExperience;
use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JsonToCvConverterTest extends KernelTestCase
{
    private JsonToCvConverter $converter;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->converter = self::$kernel->getContainer()->get(JsonToCvConverter::class);
    }

    public function testConversion(): void
    {
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $cv = $this->converter->convert($inputJson);
        $this->assertPersonalDetailsValidConversion($cv->getPersonalDetails());
        $this->assertCoverLetterValidConversion($cv->getCoverLetter());
        $this->assertAcademicExperiencesValidConversion($cv->getAcademicExperiences());
        $this->assertWorkExperiencesValidConversion($cv->getWorkExperiences());
    }

    private function assertPersonalDetailsValidConversion(PersonalDetails $personalDetails): void
    {
        $this->assertEquals('Max', $personalDetails->getName());
        $this->assertEquals('Mustermann', $personalDetails->getSurname());
        $this->assertEquals('max@mustermann.com', $personalDetails->getEmail());
        $this->assertEquals('555-55-55-55', $personalDetails->getPhoneNumber());
    }

    private function assertCoverLetterValidConversion(CoverLetter $coverLetter): void{
        $this->assertEquals('Lorem ipsum dolor sit amet...', $coverLetter->getText());
    }

    private function assertAcademicExperiencesValidConversion(AcademicExperiences $academicExperiences): void{
        $this->assertCount(2, $academicExperiences->getAcademicExperiences());

        /** @var AcademicExperience $academicExperience1 */
        $academicExperience1 = $academicExperiences->getAcademicExperiences()[0];
        $this->assertEquals('The IT University', $academicExperience1->getSchoolName());
        $this->assertEquals('Computer Engineer', $academicExperience1->getTitle());
        $this->assertEquals('Final Career Project on Machine Learning', $academicExperience1->getAdditionalInfo());

        $dateRange = $academicExperience1->getDateRange();
        $this->assertEquals('01-09-2008', $dateRange->getIniDate()->format('d-m-Y'));
        $this->assertEquals('30-06-2014', $dateRange->getEndDate()->format('d-m-Y'));

        /** @var AcademicExperience $academicExperience2 */
        $academicExperience2 = $academicExperiences->getAcademicExperiences()[1];
        $this->assertEquals('The IT Institute', $academicExperience2->getSchoolName());
        $this->assertEquals('Technical Software Developer', $academicExperience2->getTitle());
        $this->assertEquals("6 months internship at 'Another Cool Company'", $academicExperience2->getAdditionalInfo());

        $dateRange = $academicExperience2->getDateRange();
        $this->assertEquals('01-09-2006', $dateRange->getIniDate()->format('d-m-Y'));
        $this->assertEquals('30-06-2008', $dateRange->getEndDate()->format('d-m-Y'));
    }

    private function assertWorkExperiencesValidConversion(WorkExperiences $workExperiences): void
    {
        $this->assertCount(2, $workExperiences->getWorkExperiences());

        /** @var WorkExperience $workExperience1 */
        $workExperience1 = $workExperiences->getWorkExperiences()[0];
        $this->assertEquals('My Awesome Company', $workExperience1->getCompanyName());
        $this->assertEquals('Senior developer', $workExperience1->getPosition());
        $this->assertEquals('Taking care of refactoring the project to clean code and clean architectures.', $workExperience1->getTasksDescription());

        $dateRange = $workExperience1->getDateRange();
        $this->assertEquals('15-11-2016', $dateRange->getIniDate()->format('d-m-Y'));
        $this->assertEquals('31-05-2018', $dateRange->getEndDate()->format('d-m-Y'));

        /** @var WorkExperience $workExperience2 */
        $workExperience2 = $workExperiences->getWorkExperiences()[1];
        $this->assertEquals('Another Cool Company', $workExperience2->getCompanyName());
        $this->assertEquals('Senior - intermediate developer', $workExperience2->getPosition());
        $this->assertEquals("Collaborating with IT Lead to design the project.", $workExperience2->getTasksDescription());

        $dateRange = $workExperience2->getDateRange();
        $this->assertEquals('01-08-2014', $dateRange->getIniDate()->format('d-m-Y'));
        $this->assertEquals('01-10-2018', $dateRange->getEndDate()->format('d-m-Y'));
    }
}
