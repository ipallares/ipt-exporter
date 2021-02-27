<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\exporter;

use App\exporter\application\services\factory\CompositeExporterFactory;
use App\exporter\infrastructure\adapters\DocxExporter;
use App\exporter\infrastructure\adapters\PdfExporter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExporterTest extends KernelTestCase
{
    private CompositeExporterFactory $factory;
    private DocxExporter $docxExporter;
    private PdfExporter $pdfExporter;
    private string $inputJson;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->factory = self::$kernel->getContainer()->get(CompositeExporterFactory::class);
        $this->docxExporter = self::$kernel->getContainer()->get(DocxExporter::class);
        $this->pdfExporter = self::$kernel->getContainer()->get(PdfExporter::class);
        $this->inputJson = $this->getInputJson_v1();
    }

    public function testExport_Word_cv1_v1(): void
    {
        $expected = $this->getExpected_Word_cv1_v1();
        $composite = $this->factory->create($this->getInputJson_v1());
        $exported = $composite->export($this->docxExporter);
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Word_cv2_v1(): void
    {
        $expected = $this->getExpected_Word_cv2_v1();
        $composite = $this->factory->create($this->getInputJson_v2());
        $exported = $composite->export($this->docxExporter);
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Pdf_cv1_v1(): void
    {
        $expected = $this->getExpected_Pdf_cv1_v1();
        $composite = $this->factory->create($this->getInputJson_v1());
        $exported = $composite->export($this->pdfExporter);
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Pdf_cv2_v1(): void
    {
        $expected = $this->getExpected_Pdf_cv2_v1();
        $composite = $this->factory->create($this->getInputJson_v2());
        $exported = $composite->export($this->pdfExporter);
        $this->assertEquals($expected, $exported);
    }

    private function getInputJson_v1()
    {
        return file_get_contents('tests/exporter/application/services/exporter/input-data/cv1-v1.json');
    }

    private function getInputJson_v2()
    {
        return file_get_contents('tests/exporter/application/services/exporter/input-data/cv2-v1.json');
    }

    private function getExpected_Word_cv1_v1(): string
    {
        $expected = file_get_contents('tests/exporter/application/services/exporter/expected-documents/docx-cv1-v1.xml');

        return $this->cleanString($expected);
    }

    private function getExpected_Word_cv2_v1(): string
    {
        $expected = file_get_contents('tests/exporter/application/services/exporter/expected-documents/docx-cv2-v1.xml');

        return $this->cleanString($expected);
    }

    private function getExpected_Pdf_cv1_v1(): string
    {
        $expected = file_get_contents('tests/exporter/application/services/exporter/expected-documents/pdf-cv1-v1.xml');

        return $this->cleanString($expected);
    }

    private function getExpected_Pdf_cv2_v1(): string
    {
        $expected = file_get_contents('tests/exporter/application/services/exporter/expected-documents/pdf-cv2-v1.xml');

        return $this->cleanString($expected);
    }

    private function cleanString(string $text): string
    {
        return str_replace(["\t", "\n", "  "], '', $text);
    }
}
