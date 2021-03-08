<?php

namespace App\exporter\application\services\exporter\traits;

trait ExportersHelperTrait
{
    protected function openTag($tag): string
    {
        if ($this->isValidTag($tag)) {
            return "<$tag>" . PHP_EOL;
        }

        return '';
    }

    protected function closeTag($tag): string
    {
        if ($this->isValidTag($tag)) {
            return "</$tag>" . PHP_EOL;
        }

        return '';
    }

    protected function isValidTag($tag): bool
    {
        return is_string($tag) && '' !== $tag;
    }

    protected function getItemStringContent($item): string {
        return is_string($item) ?  $item . PHP_EOL : '';
    }
}
