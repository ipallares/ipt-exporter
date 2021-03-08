<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\exporter;

use App\exporter\application\services\exporter\ExporterWithRecursiveIteratorIterator;

class ExporterWithRecursiveIteratorIteratorTest extends ExporterTest
{
    protected function getExporter()
    {
        return self::$container->get(ExporterWithRecursiveIteratorIterator::class);
    }
}
