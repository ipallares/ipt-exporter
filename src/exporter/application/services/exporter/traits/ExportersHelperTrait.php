<?php

namespace App\exporter\application\services\exporter\traits;

trait ExportersHelperTrait
{
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

    private function getItemStringContent($item): string {
        return is_string($item) ?  $item . PHP_EOL : '';
    }
}
