<?php

declare(strict_types=1);

namespace App\exporter\domain\model\interfaces;

interface MultipleContentLengthExportInterface
{
    public function exportCompressed(): string;

    public function exportExtended(): string;
}
