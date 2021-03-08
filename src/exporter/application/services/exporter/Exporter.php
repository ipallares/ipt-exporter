<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\core\application\services\validators\JsonSchemaValidator;
use App\exporter\application\services\exporter\traits\ExportersHelperTrait;
use App\exporter\domain\ports\DocumentTypeExporterInterface;
use App\exporter\domain\services\DocumentTypeExporterFinder;
use Iterator;

abstract class Exporter
{
    use ExportersHelperTrait;

    private DocumentTypeExporterFinder $documentTypeExporterFinder;
    private JsonSchemaValidator $schemaValidator;
    private string $cvSchemaV1;

    public function __construct(
        DocumentTypeExporterFinder $documentTypeExporterFinder,
        JsonSchemaValidator $schemaValidator,
        string $cvSchemaV1
    )
    {
        $this->documentTypeExporterFinder = $documentTypeExporterFinder;
        $this->schemaValidator = $schemaValidator;
        $this->cvSchemaV1 = $cvSchemaV1;
    }

    public function export(string $json, string $documentType, string $cvSchemaV1): string
    {
        // IPT: TODO: Check if here some pattern to chain calls for validation and getDocumentTypExporter
        $this->schemaValidator->validate($json, $cvSchemaV1);
        $documentTypeExporter = $this->documentTypeExporterFinder->find($documentType);

        $iterator = $this->getIterator($json);

        return $this->doExport($documentTypeExporter, $iterator);
    }

    protected function doExport(
        DocumentTypeExporterInterface $documentTypeExporter,
        Iterator $iterator,
        int $depth = 0
    ): string {

        $exportedText = '';
        foreach ($iterator as $tag => $item) {
            $exportedText .= $this->isCompoundItem($item, $tag)
                ? $this->getCompoundItemContent($documentTypeExporter, $iterator, $tag, $depth)
                : $this->getSingleItemContent($documentTypeExporter, $item, $tag);
        }

        return $exportedText;
    }

    /**
     * @param array | string $item
     * @param int | string $tag
     */
    private function getSingleItemContent(DocumentTypeExporterInterface $documentTypeExporter, $item, $tag): string {
        $openTag = $this->openTag($tag);
        $content = $this->getItemStringContent($item);
        $closeTag = $this->closeTag($tag);

        return $documentTypeExporter->addContent($openTag . $content . $closeTag);
    }

    /**
     * @param array | string $tag
     * @param int | string $tag
     */
    protected abstract function isCompoundItem($item, $tag = ''): bool;

    /**
     * @param int | string $tag
     */
    abstract protected function getCompoundItemContent(
        DocumentTypeExporterInterface $documentTypeExporter,
        Iterator $iterator,
        $tag,
        int $depth = 0
    ): string;

    abstract protected function getIterator(string $json): Iterator;
}
