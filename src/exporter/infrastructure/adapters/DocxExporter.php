<?php

declare(strict_types=1);

namespace App\exporter\infrastructure\adapters;

use App\exporter\domain\ports\DocumentTypeExporterInterface;

class DocxExporter implements DocumentTypeExporterInterface
{
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
}
