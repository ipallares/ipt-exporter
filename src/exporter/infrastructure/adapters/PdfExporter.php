<?php

declare(strict_types=1);

namespace App\exporter\infrastructure\adapters;

use App\exporter\domain\ports\DocumentTypeExporterInterface;

class PdfExporter implements DocumentTypeExporterInterface
{
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
}
