<?php

declare(strict_types=1);

namespace App\exporter\domain\services;

use App\exporter\domain\ports\DocumentTypeExporterInterface;
use InvalidArgumentException;
use Traversable;

class DocumentTypeExporterFinder
{
    /** @var Traversable<int, DocumentTypeExporterInterface> */
    private Traversable $documentTypeExporters;

    /**
     * @param Traversable<int, DocumentTypeExporterInterface> $documentTypeExporters
     */
    public function __construct(Traversable $documentTypeExporters)
    {
        $this->documentTypeExporters = $documentTypeExporters;
    }

    public function find(string $documentType): DocumentTypeExporterInterface
    {
        foreach($this->documentTypeExporters as $documentTypeExporter) {
            /** @var DocumentTypeExporterInterface $documentTypeExporter */
            if ($documentTypeExporter->supports($documentType)) {
                return $documentTypeExporter;
            }
        }

        throw new InvalidArgumentException("'$documentType' is not supported by any exporter.");
    }

    public function search(string $documentType): ?DocumentTypeExporterInterface
    {
        foreach($this->documentTypeExporters as $documentTypeExporter) {
            /** @var DocumentTypeExporterInterface $documentTypeExporter */
            if ($documentTypeExporter->supports($documentType)) {
                return $documentTypeExporter;
            }
        }

        return null;
    }
}
