<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\exporter;

use App\exporter\application\services\exporter\ExporterWithRecursiveArrayIterator;
use App\exporter\infrastructure\adapters\DocxExporter;
use App\exporter\infrastructure\adapters\PdfExporter;
use App\Tests\exporter\application\services\exporter\traits\ExportersTestHelperTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExporterWithRecursiveArrayIteratorTest extends KernelTestCase
{
    use ExportersTestHelperTrait;

    private ExporterWithRecursiveArrayIterator $exporter;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->exporter = self::$container->get(ExporterWithRecursiveArrayIterator::class);
    }

    public function testWordExport_cv1_v1(): void
    {
        $expected = $this->getExpected_Word_cv1_v1();

        $exported = $this->exporter->export(
            $this->getInputJson_cv1(),
            DocxExporter::SUPPORTED_DOCUMENT_TYPE,
            self::$container->getParameter('cv_schema_v1')
        );

        $this->assertEquals($expected, $this->cleanString($exported));
    }

    public function testWordExport_cv2_v1(): void
    {
        $expected = $this->getExpected_Word_cv2_v1();

        $exported = $this->exporter->export(
            $this->getInputJson_cv2(),
            DocxExporter::SUPPORTED_DOCUMENT_TYPE,
            self::$container->getParameter('cv_schema_v1')
        );

        $this->assertEquals($expected, $this->cleanString($exported));
    }

    public function testPdfExport_cv1_v1(): void
    {
        $expected = $this->getExpected_Pdf_cv1_v1();

        $exported = $this->exporter->export(
            $this->getInputJson_cv1(),
            PdfExporter::SUPPORTED_DOCUMENT_TYPE,
            self::$container->getParameter('cv_schema_v1')
        );

        $this->assertEquals($expected, $this->cleanString($exported));
    }

    public function testPdfExport_cv2_v1(): void
    {
        $expected = $this->getExpected_Pdf_cv2_v1();

        $exported = $this->exporter->export(
            $this->getInputJson_cv2(),
            PdfExporter::SUPPORTED_DOCUMENT_TYPE,
            self::$container->getParameter('cv_schema_v1')
        );

        $this->assertEquals($expected, $this->cleanString($exported));
    }
}
