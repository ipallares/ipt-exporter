<?php

declare(strict_types=1);

namespace App\exporter\domain\model\sections;

use App\exporter\domain\model\interfaces\MultipleContentLengthExportInterface;

class CoverLetter implements MultipleContentLengthExportInterface
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function exportExtended(): string
    {
        return "<coverletter>" . $this->getText() . "</coverletter>";
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function exportCompressed(): string
    {
        return '';
    }
}
