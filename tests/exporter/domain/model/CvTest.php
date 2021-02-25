<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model;

use App\exporter\domain\model\blocks\AcademicExperience;
use App\exporter\domain\model\blocks\DateRange;
use App\exporter\domain\model\blocks\WorkExperience;
use App\exporter\domain\model\CV;
use App\exporter\domain\model\fields\Email;
use App\exporter\domain\model\fields\Name;
use App\exporter\domain\model\fields\PhoneNumber;
use App\exporter\domain\model\fields\Surname;
use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;
use Exception;
use PHPUnit\Framework\TestCase;

class CvTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCompressedExport()
    {
        // Personal Details
        $name = new Name('Max');
        $surname = new Surname('Mustermann');
        $email = new Email('max@mustermann.com');
        $phoneNumber = new PhoneNumber('555-55-55-55');
        $personalDetails = new PersonalDetails($name, $surname, $email, $phoneNumber);

        // Cover letter
        $coverLetter = new CoverLetter('Lorem ipsum dolor sit amet...');

        // Work experiences
        $dateRange = DateRange::fromTimestamps(strtotime("24-02-2020"), strtotime('24-03-2020'));
        $workExperience1 = new WorkExperience('company name 1', 'title 1', $dateRange, 'description 1');
        $workExperience2 = new WorkExperience('company name 2', 'title 2', $dateRange, 'description 2');
        $workExperiences = new WorkExperiences([$workExperience1, $workExperience2]);

        // Academic Experiences
        $dateRange = DateRange::fromTimestamps(strtotime("24-02-2020"), strtotime('24-03-2020'));
        $academicExperience1 = new AcademicExperience('school name 1', 'title 1', $dateRange, 'additional info 1');
        $academicExperience2 = new AcademicExperience('school name 2', 'title 2', $dateRange, 'additional info 2');
        $academicExperiences = new AcademicExperiences([$academicExperience1, $academicExperience2]);

        $cv = new CV($personalDetails, $coverLetter, $workExperiences, $academicExperiences);

        // Compressed personal details
        $expected = '<compressed-personaldetails><name>Max</name><surname>Mustermann</surname></compressed-personaldetails>';
        $exported = $cv->exportPersonalDetailsCompressed();
        $this->assertEquals($expected, $exported);

        // Extended personal details
        $expected = '<extended-personaldetails><name>Max</name><surname>Mustermann</surname><email>max@mustermann.com</email><phonenumber>555-55-55-55</phonenumber></extended-personaldetails>';
        $exported = $cv->exportPersonalDetailsExtended();
        $this->assertEquals($expected, $exported);

        // Extended cover letter (there is no possible compressed version for cover letter)
        $expected = '<coverletter>Lorem ipsum dolor sit amet...</coverletter>';
        $exported = $cv->exportCoverLetterExtended();
        $this->assertEquals($expected, $exported);

        // Compressed Work Experiences
        $expected = '<compressed-workexperiences><compressed-workexperience><daterange>24-02-2020 - 24-03-2020</daterange><companyname>company name 1</companyname><position>title 1</position></compressed-workexperience><compressed-workexperience><daterange>24-02-2020 - 24-03-2020</daterange><companyname>company name 2</companyname><position>title 2</position></compressed-workexperience><compressed-workexperiences>';
        $exported = $cv->exportWorkExperiencesCompressed();
        $this->assertEquals($expected, $exported);

        // Extended Work Experiences
        $expected = '<extended-workexperiences><extended-workexperience><daterange>24-02-2020 - 24-03-2020</daterange><companyname>company name 1</companyname><position>title 1</position><taskdescription>description 1</taskdescription></extended-workexperience><extended-workexperience><daterange>24-02-2020 - 24-03-2020</daterange><companyname>company name 2</companyname><position>title 2</position><taskdescription>description 2</taskdescription></extended-workexperience><extended-workexperiences>';
        $exported = $cv->exportWorkExperiencesExtended();
        $this->assertEquals($expected, $exported);

        // Compressed Academic Experiences
        $expected = '<compressed-academicexperiences><compressed-academicexperience><daterange>24-02-2020 - 24-03-2020</daterange><schoolname>school name 1</schoolname><title>title 1</title></compressed-academicexperience><compressed-academicexperience><daterange>24-02-2020 - 24-03-2020</daterange><schoolname>school name 2</schoolname><title>title 2</title></compressed-academicexperience><compressed-academicexperiences>';
        $exported = $cv->exportAcademicExperiencesCompressed();
        $this->assertEquals($expected, $exported);

        // Extended Academic Experiences
        $expected = '<extended-academicexperiences><extended-academicexperience><daterange>24-02-2020 - 24-03-2020</daterange><schoolname>school name 1</schoolname><title>title 1</title><additionalinfo>additional info 1</additionalinfo></extended-academicexperience><extended-academicexperience><daterange>24-02-2020 - 24-03-2020</daterange><schoolname>school name 2</schoolname><title>title 2</title><additionalinfo>additional info 2</additionalinfo></extended-academicexperience><extended-academicexperiences>';
        $exported = $cv->exportAcademicExperiencesExtended();
        $this->assertEquals($expected, $exported);
    }
}
