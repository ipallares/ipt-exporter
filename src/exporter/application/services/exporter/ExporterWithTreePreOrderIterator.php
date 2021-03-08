<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\core\application\services\TreePreOrderIterator;
use App\exporter\domain\ports\DocumentTypeExporterInterface;
use Iterator;

class ExporterWithTreePreOrderIterator extends Exporter
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
            $headerTag = 0 === $iterator->getDepth() ? 'section' : 'block';
            $result = $documentTypeExporter->addContent("<$headerTag>$tag</$headerTag>");
        }

        return $result;
    }

    protected function getIterator(string $json): Iterator
    {
        return new TreePreOrderIterator(json_decode($json, true));
    }
}
