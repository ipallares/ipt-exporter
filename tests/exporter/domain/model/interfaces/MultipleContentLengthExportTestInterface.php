<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\interfaces;

interface MultipleContentLengthExportTestInterface
{
    public function testCompressedExport(): void;

    public function testExtendedExport(): void;
}
