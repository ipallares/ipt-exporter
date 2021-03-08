<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\exporter\domain\ports\DocumentTypeExporterInterface;
use Iterator;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ExporterWithRecursiveArrayIterator extends Exporter
{

    protected function isCompoundItem($item, $tag = ''): bool
    {
        return is_array($item);
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

        $result = '';
        if ($this->isValidTag($tag)) {
            $headerTag = 0 === $depth ? 'section' : 'block';
            $result = $documentTypeExporter->addContent("<$headerTag>$tag</$headerTag>");
        }

        return  $result . $this->doExport($documentTypeExporter, $iterator->getChildren(), ++$depth);
    }

    protected function getIterator(string $json): Iterator
    {
        return new RecursiveArrayIterator(
            json_decode($json, true),
            RecursiveIteratorIterator::SELF_FIRST
        );
    }
}
