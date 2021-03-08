<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\exporter\domain\ports\DocumentTypeExporterInterface;
use Iterator;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ExporterWithRecursiveIteratorIterator extends Exporter
{

    protected function isCompoundItem($item, $tag = ''): bool
    {
        return !is_string($item) && $this->isValidTag($tag);
    }

    /**
     * @param int | string $tag
     */
    protected function getCompoundItemContent(
        DocumentTypeExporterInterface $documentTypeExporter,
        Iterator $iterator,
        $tag,
        int $depth = 0
    ): string {

        $headerTag = 0 === $iterator->getDepth() ? 'section' : 'block';

        return  $documentTypeExporter->addContent("<$headerTag>$tag</$headerTag>");
    }

    protected function getIterator(string $json): Iterator
    {
        return new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($json, true)),
            RecursiveIteratorIterator::SELF_FIRST
        );
    }
}
