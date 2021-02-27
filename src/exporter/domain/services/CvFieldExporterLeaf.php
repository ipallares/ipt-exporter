<?php

declare(strict_types=1);

namespace App\exporter\domain\services;

use App\exporter\domain\ports\DocumentTypeExporterInterface;
use App\exporter\domain\services\interfaces\CvPartExporterComponentInterface;

class CvFieldExporterLeaf implements CvPartExporterComponentInterface
{
    private string $label;

    private string $text;

    public function __construct(string $label, string $text)
    {
        $this->label = $label;
        $this->text = $text;
    }

    public function export(DocumentTypeExporterInterface $documentTypeExporter): string
    {
        return $documentTypeExporter->addContent("<$this->label>$this->text</$this->label>");
    }
}
