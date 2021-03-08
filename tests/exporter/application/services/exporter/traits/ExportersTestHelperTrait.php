<?php

namespace App\Tests\exporter\application\services\exporter\traits;

trait ExportersTestHelperTrait
{
    private function getInputJson_cv1(): string
    {
        return file_get_contents('tests/exporter/application/services/exporter/input-data/cv1-v1.json');
    }

    private function getInputJson_cv2(): string
    {
        return file_get_contents('tests/exporter/application/services/exporter/input-data/cv2-v1.json');
    }

    private function getInputJsonArray_cv1(): object
    {
        return json_decode($this->getInputJson_cv1());
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
        return str_replace(["\t", "\n", "\r", "  "], '', $text);
    }
}
