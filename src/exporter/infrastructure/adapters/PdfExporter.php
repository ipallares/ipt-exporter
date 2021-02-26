<?php

declare(strict_types=1);

namespace App\exporter\infrastructure\adapters;

use App\exporter\domain\ports\DocumentTypeExporterInterface;

class PdfExporter implements DocumentTypeExporterInterface
{
    public const SUPPORTED_DOCUMENT_TYPE = 'pdf';

    public function addTable(string $text): string
    {
        return '' === $text
                ? ''
                : "<pdf-table>$text</pdf-table>";
    }

    public function addRow(string $text): string
    {
        return '' === $text
                ? ''
                : "<pdf-row>$text</pdf-row>";
    }

    public function addCell(string $text): string
    {
        return '' === $text
                ? ''
                : "<pdf-cell>$text</pdf-cell>";
    }

    public function addContent(string $text): string
    {
        return '' === $text
            ? ''
            : "<pdf-content>$text</pdf-content>";
    }

    public function supports(string $documentType): bool
    {
        return self::SUPPORTED_DOCUMENT_TYPE === $documentType;
    }
}
