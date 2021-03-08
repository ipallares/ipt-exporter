<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\core\application\services\validators\JsonSchemaValidator;
use App\exporter\domain\ports\DocumentTypeExporterInterface;
use App\exporter\domain\services\DocumentTypeExporterFinder;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ExporterWithRecursiveIteratorIterator
{
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

        $iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($json, true)),
            RecursiveIteratorIterator::SELF_FIRST
        );

        return $this->exportRecursive($documentTypeExporter, $iterator);
    }

    private function exportRecursive(
        DocumentTypeExporterInterface $documentTypeExporter,
        RecursiveIteratorIterator $iterator
    ): string {

        $exportedText = '';
        foreach ($iterator as $tag => $item) {
            $exportedText .= $this->isCompoundItem($item, $tag)
                ? $this->getCompoundItemContent($documentTypeExporter, $iterator, $tag)
                : $this->getSingleItemContent($documentTypeExporter, $item, $tag);
        }

        return $exportedText;
    }

    private function isCompoundItem($item, $tag): bool
    {
        return !is_string($item) && $this->isValidTag($tag);
    }

    /**
     * @param int | string $tag
     */
    private function getCompoundItemContent(
        DocumentTypeExporterInterface $documentTypeExporter,
        RecursiveIteratorIterator $iterator,
        $tag
    ): string {

        $headerTag = 0 === $iterator->getDepth() ? 'section' : 'block';

        return  $documentTypeExporter->addContent("<$headerTag>$tag</$headerTag>");
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

    private function getItemStringContent($item): string {
        return is_string($item) ?  $item . PHP_EOL : '';
    }

    private function openTag($tag): string
    {
        if ($this->isValidTag($tag)) {
            return "<$tag>" . PHP_EOL;
        }

        return '';
    }

    private function closeTag($tag): string
    {
        if ($this->isValidTag($tag)) {
            return "</$tag>" . PHP_EOL;
        }

        return '';
    }

    private function isValidTag($tag): bool
    {
        return is_string($tag) && '' !== $tag;
    }
}
