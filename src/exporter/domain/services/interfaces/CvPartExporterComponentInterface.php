<?php

namespace App\exporter\domain\services\interfaces;

use App\exporter\domain\ports\DocumentTypeExporterInterface;

interface CvPartExporterComponentInterface
{
    public function export(DocumentTypeExporterInterface $documentTypeExporter): string;
}
