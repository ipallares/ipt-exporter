<?php

declare(strict_types=1);

namespace App\exporter\domain\model\interfaces;

interface SingleContentLengthExportInterface
{
    public function export(): string;
}
