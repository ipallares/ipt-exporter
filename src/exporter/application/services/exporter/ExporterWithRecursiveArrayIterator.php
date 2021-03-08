<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\core\application\services\validators\JsonSchemaValidator;
use App\exporter\application\services\exporter\traits\ExportersHelperTrait;
use App\exporter\domain\ports\DocumentTypeExporterInterface;
use App\exporter\domain\services\DocumentTypeExporterFinder;
use Iterator;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ExporterWithRecursiveArrayIterator
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
        // Get the proper Strategy by passing the expected documentType and a 'supports' method implemented by every Strategy.
        $documentTypeExporter = $this->documentTypeExporterFinder->find($documentType);

        $iterator = new RecursiveArrayIterator(
            json_decode($json, true),
            RecursiveIteratorIterator::SELF_FIRST
        );

        return $this->doExport($documentTypeExporter, $iterator);
    }

    private function doExport(
        DocumentTypeExporterInterface $documentTypeExporter,
        RecursiveArrayIterator $iterator,
        int $depth = 0
    ): string {

        $exportedText = '';
        foreach ($iterator as $tag => $item) {
            //$exportedText .= $this->exportPart($documentTypeExporter, $iterator, $key, $item);
            $exportedText .= $this->isCompoundItem($item)
                ? $this->getCompoundItemContent($documentTypeExporter, $iterator, $tag, $depth)
                : $this->getSingleItemContent($documentTypeExporter, $item, $tag);
        }

        return $exportedText;
    }

    private function isCompoundItem($item, $tag = ''): bool
    {
        return is_array($item);
    }

    /**
     * @param int | string $tag
     */
    private function getCompoundItemContent(
        DocumentTypeExporterInterface $documentTypeExporter,
        Iterator $iterator,
        $tag,
        int $depth
    ): string {

        $result = '';
        if ($this->isValidTag($tag)) {
            $headerTag = 0 === $depth ? 'section' : 'block';
            $result = $documentTypeExporter->addContent("<$headerTag>$tag</$headerTag>");
        }

        return  $result . $this->doExport($documentTypeExporter, $iterator->getChildren(), ++$depth);
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
}
