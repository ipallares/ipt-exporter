<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\exporter\application\services\factory\CompositeExporterFactory;
use App\exporter\domain\ports\DocumentTypeExporterInterface;
use InvalidArgumentException;
use Traversable;

abstract class Exporter
{
    private CompositeExporterFactory $factory;

    /** @var array<int, DocumentTypeExporterInterface> */
    private array $documentTypeExporters;

    /**
     * @param Traversable<int, DocumentTypeExporterInterface> $documentTypeExporters
     */
    public function __construct(CompositeExporterFactory $factory, Traversable $documentTypeExporters)
    {
        $this->factory = $factory;
        $this->documentTypeExporters = iterator_to_array($documentTypeExporters);
    }

    public function export(string $json, string $documentType): string
    {
        // Get the proper Strategy by passing the expected documentType and a 'supports' method implemented by every Strategy.
        $documentTypeExporter = $this->getDocumentTypeExporter($documentType);
        $exporter = $this->factory->create($json);

        return $exporter->export($documentTypeExporter);
    }

    private function getDocumentTypeExporter(string $documentType): DocumentTypeExporterInterface
    {
        foreach($this->documentTypeExporters as $documentTypeExporter) {
            /** @var DocumentTypeExporterInterface $documentTypeExporter */
            if ($documentTypeExporter->supports($documentType)) {
                return $documentTypeExporter;
            }
        }

        throw new InvalidArgumentException("'$documentType' is not supported by any exporter.");
    }
}
