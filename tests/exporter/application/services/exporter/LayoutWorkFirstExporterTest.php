<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\exporter;

use App\exporter\application\services\converter\inputJsonSchemaV1\JsonToCvConverter;
use App\exporter\application\services\exporter\LayoutWorkFirstExporter;
use App\exporter\domain\services\CompressedExporter;
use App\exporter\domain\services\ExtendedExporter;
use App\exporter\infrastructure\adapters\DocxExporter;
use App\exporter\infrastructure\adapters\PdfExporter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LayoutWorkFirstExporterTest extends KernelTestCase
{
    private LayoutWorkFirstExporter $exporter;
    private JsonToCvConverter $converter;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->exporter = self::$kernel->getContainer()->get(LayoutWorkFirstExporter::class);
        $this->converter = self::$kernel->getContainer()->get(JsonToCvConverter::class);
    }

    public function testExport_Docx_Compressed_WorkFirst(): void
    {
        $expected = "<docx-content><recruiterheader>My Awesome Recruitment Company</recruiterheader></docx-content><docx-content><compressed-personaldetails><name>Max</name><surname>Mustermann</surname></compressed-personaldetails></docx-content><docx-content><recruiterbanner></recruiterbanner></docx-content><docx-content><compressed-workexperiences><compressed-workexperience><daterange>15-11-2016 - 31-05-2018</daterange><companyname>My Awesome Company</companyname><position>Senior developer</position></compressed-workexperience><compressed-workexperience><daterange>01-08-2014 - 01-10-2018</daterange><companyname>Another Cool Company</companyname><position>Senior - intermediate developer</position></compressed-workexperience><compressed-workexperiences></docx-content><docx-content><compressed-academicexperiences><compressed-academicexperience><daterange>01-09-2008 - 30-06-2014</daterange><schoolname>The IT University</schoolname><title>Computer Engineer</title></compressed-academicexperience><compressed-academicexperience><daterange>01-09-2006 - 30-06-2008</daterange><schoolname>The IT Institute</schoolname><title>Technical Software Developer</title></compressed-academicexperience><compressed-academicexperiences></docx-content>";
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $cv = $this->converter->convert($inputJson);
        $exported = $this->exporter->export(
            $cv,
            DocxExporter::SUPPORTED_DOCUMENT_TYPE,
            CompressedExporter::CONTENT_LENGTH_TYPE_COMPRESSED
        );
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Docx_Extended_WorkFirst(): void
    {
        $expected = "<docx-content><recruiterheader>My Awesome Recruitment Company</recruiterheader></docx-content><docx-content><extended-personaldetails><name>Max</name><surname>Mustermann</surname><email>max@mustermann.com</email><phonenumber>555-55-55-55</phonenumber></extended-personaldetails></docx-content><docx-content><coverletter>Lorem ipsum dolor sit amet...</coverletter></docx-content><docx-content><recruiterbanner></recruiterbanner></docx-content><docx-content><extended-workexperiences><extended-workexperience><daterange>15-11-2016 - 31-05-2018</daterange><companyname>My Awesome Company</companyname><position>Senior developer</position><taskdescription>Taking care of refactoring the project to clean code and clean architectures.</taskdescription></extended-workexperience><extended-workexperience><daterange>01-08-2014 - 01-10-2018</daterange><companyname>Another Cool Company</companyname><position>Senior - intermediate developer</position><taskdescription>Collaborating with IT Lead to design the project.</taskdescription></extended-workexperience><extended-workexperiences></docx-content><docx-content><extended-academicexperiences><extended-academicexperience><daterange>01-09-2008 - 30-06-2014</daterange><schoolname>The IT University</schoolname><title>Computer Engineer</title><additionalinfo>Final Career Project on Machine Learning</additionalinfo></extended-academicexperience><extended-academicexperience><daterange>01-09-2006 - 30-06-2008</daterange><schoolname>The IT Institute</schoolname><title>Technical Software Developer</title><additionalinfo>6 months internship at 'Another Cool Company'</additionalinfo></extended-academicexperience><extended-academicexperiences></docx-content>";
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $cv = $this->converter->convert($inputJson);
        $exported = $this->exporter->export(
            $cv,
            DocxExporter::SUPPORTED_DOCUMENT_TYPE,
            ExtendedExporter::CONTENT_LENGTH_TYPE_EXTENDED
        );
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Pdf_Compressed_WorkFirst(): void
    {
        $expected = "<pdf-content><recruiterheader>My Awesome Recruitment Company</recruiterheader></pdf-content><pdf-content><compressed-personaldetails><name>Max</name><surname>Mustermann</surname></compressed-personaldetails></pdf-content><pdf-content><recruiterbanner></recruiterbanner></pdf-content><pdf-content><compressed-workexperiences><compressed-workexperience><daterange>15-11-2016 - 31-05-2018</daterange><companyname>My Awesome Company</companyname><position>Senior developer</position></compressed-workexperience><compressed-workexperience><daterange>01-08-2014 - 01-10-2018</daterange><companyname>Another Cool Company</companyname><position>Senior - intermediate developer</position></compressed-workexperience><compressed-workexperiences></pdf-content><pdf-content><compressed-academicexperiences><compressed-academicexperience><daterange>01-09-2008 - 30-06-2014</daterange><schoolname>The IT University</schoolname><title>Computer Engineer</title></compressed-academicexperience><compressed-academicexperience><daterange>01-09-2006 - 30-06-2008</daterange><schoolname>The IT Institute</schoolname><title>Technical Software Developer</title></compressed-academicexperience><compressed-academicexperiences></pdf-content>";
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $cv = $this->converter->convert($inputJson);
        $exported = $this->exporter->export(
            $cv,
            PdfExporter::SUPPORTED_DOCUMENT_TYPE,
            CompressedExporter::CONTENT_LENGTH_TYPE_COMPRESSED
        );
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Pdf_Extended_WorkFirst(): void
    {
        $expected = "<pdf-content><recruiterheader>My Awesome Recruitment Company</recruiterheader></pdf-content><pdf-content><extended-personaldetails><name>Max</name><surname>Mustermann</surname><email>max@mustermann.com</email><phonenumber>555-55-55-55</phonenumber></extended-personaldetails></pdf-content><pdf-content><coverletter>Lorem ipsum dolor sit amet...</coverletter></pdf-content><pdf-content><recruiterbanner></recruiterbanner></pdf-content><pdf-content><extended-workexperiences><extended-workexperience><daterange>15-11-2016 - 31-05-2018</daterange><companyname>My Awesome Company</companyname><position>Senior developer</position><taskdescription>Taking care of refactoring the project to clean code and clean architectures.</taskdescription></extended-workexperience><extended-workexperience><daterange>01-08-2014 - 01-10-2018</daterange><companyname>Another Cool Company</companyname><position>Senior - intermediate developer</position><taskdescription>Collaborating with IT Lead to design the project.</taskdescription></extended-workexperience><extended-workexperiences></pdf-content><pdf-content><extended-academicexperiences><extended-academicexperience><daterange>01-09-2008 - 30-06-2014</daterange><schoolname>The IT University</schoolname><title>Computer Engineer</title><additionalinfo>Final Career Project on Machine Learning</additionalinfo></extended-academicexperience><extended-academicexperience><daterange>01-09-2006 - 30-06-2008</daterange><schoolname>The IT Institute</schoolname><title>Technical Software Developer</title><additionalinfo>6 months internship at 'Another Cool Company'</additionalinfo></extended-academicexperience><extended-academicexperiences></pdf-content>";
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $cv = $this->converter->convert($inputJson);
        $exported = $this->exporter->export(
            $cv,
            PdfExporter::SUPPORTED_DOCUMENT_TYPE,
            ExtendedExporter::CONTENT_LENGTH_TYPE_EXTENDED
        );
        $this->assertEquals($expected, $exported);
    }
}
