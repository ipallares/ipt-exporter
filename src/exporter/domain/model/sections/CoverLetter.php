<?php

declare(strict_types=1);

namespace App\exporter\domain\model\sections;

use App\exporter\domain\model\interfaces\SingleContentLengthExportInterface;

class CoverLetter implements SingleContentLengthExportInterface
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function export(): string
    {
        return "<coverletter>" . $this->getText() . "</coverletter>";
    }

    public function getText(): string
    {
        return $this->text;
    }
}
