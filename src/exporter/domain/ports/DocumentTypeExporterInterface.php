<?php

declare(strict_types=1);

namespace App\exporter\domain\ports;

interface DocumentTypeExporterInterface
{
    public function addTable(string $text): string;

    public function addRow(string $text): string;

    public function addCell(string $text): string;

    public function addContent(string $text): string;

    public function supports(string $documentType): bool;
}
