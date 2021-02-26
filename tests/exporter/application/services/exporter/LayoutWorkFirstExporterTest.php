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
    private string $inputJson;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->exporter = self::$kernel->getContainer()->get(LayoutWorkFirstExporter::class);
        $this->converter = self::$kernel->getContainer()->get(JsonToCvConverter::class);
        $this->inputJson = $this->getInputJson();
    }

    public function testExport_Docx_Compressed(): void
    {
        $expected = $this->getExpected_Docx_Compressed();
        $cv = $this->converter->convert($this->inputJson);
        $exported = $this->exporter->export(
            $cv,
            DocxExporter::SUPPORTED_DOCUMENT_TYPE,
            CompressedExporter::CONTENT_LENGTH_TYPE_COMPRESSED
        );
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Docx_Extended(): void
    {
        $expected = $this->getExpected_Docx_Extended();
        $cv = $this->converter->convert($this->inputJson);
        $exported = $this->exporter->export(
            $cv,
            DocxExporter::SUPPORTED_DOCUMENT_TYPE,
            ExtendedExporter::CONTENT_LENGTH_TYPE_EXTENDED
        );
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Pdf_Compressed(): void
    {
        $expected = $this->getExpected_Pdf_Compressed();
        $cv = $this->converter->convert($this->inputJson);
        $exported = $this->exporter->export(
            $cv,
            PdfExporter::SUPPORTED_DOCUMENT_TYPE,
            CompressedExporter::CONTENT_LENGTH_TYPE_COMPRESSED
        );
        $this->assertEquals($expected, $exported);
    }

    public function testExport_Pdf_Extended(): void
    {
        $expected = $this->getExpected_Pdf_Extended();
        $cv = $this->converter->convert($this->inputJson);
        $exported = $this->exporter->export(
            $cv,
            PdfExporter::SUPPORTED_DOCUMENT_TYPE,
            ExtendedExporter::CONTENT_LENGTH_TYPE_EXTENDED
        );
        $this->assertEquals($expected, $exported);
    }

    private function getExpected_Docx_Compressed(): string
    {
        $expected = file_get_contents('tests/exporter/application/services/exporter/expected-documents/work-first-compressed-docx.xml');

        return $this->cleanString($expected);
    }

    private function getExpected_Docx_Extended(): string
    {
        $expected = file_get_contents('tests/exporter/application/services/exporter/expected-documents/work-first-extended-docx.xml');

        return $this->cleanString($expected);
    }

    private function getExpected_Pdf_Compressed(): string
    {
        $expected = file_get_contents('tests/exporter/application/services/exporter/expected-documents/work-first-compressed-pdf.xml');

        return $this->cleanString($expected);
    }

    private function getExpected_Pdf_Extended(): string
    {
        $expected = file_get_contents('tests/exporter/application/services/exporter/expected-documents/work-first-extended-pdf.xml');

        return $this->cleanString($expected);
    }

    private function cleanString(string $text): string
    {
        return str_replace(["\t", "\n", "  "], '', $text);
    }

    private function getInputJson()
    {
        return file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
    }
}
