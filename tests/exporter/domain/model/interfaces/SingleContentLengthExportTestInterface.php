<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\interfaces;

interface SingleContentLengthExportTestInterface
{
    public function testExport(): void;
}
