<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\core\application\services\validators\JsonSchemaValidator;
use App\exporter\domain\ports\DocumentTypeExporterInterface;
use InvalidArgumentException;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use SplStack;
use Traversable;

class ExporterWithRecursiveIteratorIterator
{
    private JsonSchemaValidator $schemaValidator;

    /** @var Traversable<int, DocumentTypeExporterInterface> */
    private Traversable $documentTypeExporters;

    private string $cvSchemaV1;

    private SplStack $closingTagsStack;

    /**
     * @param Traversable<int, DocumentTypeExporterInterface> $documentTypeExporters
     */
    public function __construct(
        JsonSchemaValidator $schemaValidator,
        Traversable $documentTypeExporters,
        string $cvSchemaV1
    )
    {
        $this->closingTagsStack = new SplStack();
        $this->schemaValidator = $schemaValidator;
        $this->documentTypeExporters = $documentTypeExporters;
        $this->cvSchemaV1 = $cvSchemaV1;
    }

    public function export(string $json, string $documentType, string $cvSchemaV1): string
    {
        // IPT: TODO: Check if here some pattern to chain calls for validation and getDocumentTypExporter
        $this->schemaValidator->validate($json, $cvSchemaV1);
        // Get the proper Strategy by passing the expected documentType and a 'supports' method implemented by every Strategy.
        $documentTypeExporter = $this->getDocumentTypeExporter($documentType);

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

    private function getCompoundItemContent(
        DocumentTypeExporterInterface $documentTypeExporter,
        RecursiveIteratorIterator $iterator,
        $tag
    ): string {

        $headerTag = 0 === $iterator->getDepth() ? 'section' : 'block';

        return  $documentTypeExporter->addContent("<$headerTag>$tag</$headerTag>");
    }

    private function getSingleItemContent(DocumentTypeExporterInterface $documentTypeExporter, $item, $tag): string {
        $openTag = $this->openTag($tag);
        $content = $this->getItemContent($item);
        $closeTag = $this->closeTag($tag);

        return $documentTypeExporter->addContent($openTag . $content . $closeTag);
    }

    private function getItemContent($item): string {
        return is_string($item) ?  $this->getItemString($item) : '';
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

    private function getItemString(string $text): string
    {
        return $text . PHP_EOL;
    }
}
