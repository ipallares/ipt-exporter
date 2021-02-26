<?php

declare(strict_types=1);

namespace App\exporter\infrastructure\adapters;

use App\exporter\domain\ports\DocumentTypeExporterInterface;

class DocxExporter implements DocumentTypeExporterInterface
{
    public const SUPPORTED_DOCUMENT_TYPE = 'docx';

    public function addTable(string $text): string
    {
        return '' === $text
                ? ''
                : "<docx-table>$text</docx-table>";
    }

    public function addRow(string $text): string
    {
        return '' === $text
                ? ''
                : "<docx-row>$text</docx-row>";
    }

    public function addCell(string $text): string
    {
        return '' === $text
                ? ''
                : "<docx-cell>$text</docx-cell>";
    }

    public function addContent(string $text): string
    {
        return '' === $text
            ? ''
            : "<docx-content>$text</docx-content>";
    }

    public function supports(string $documentType): bool
    {
        return self::SUPPORTED_DOCUMENT_TYPE === $documentType;
    }
}
