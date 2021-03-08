<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\exporter;

use App\exporter\application\services\exporter\ExporterWithTreePreOrderIterator;

class ExporterWithTreePreOrderIteratorTest extends ExporterTest
{
    protected function getExporter()
    {
        return self::$container->get(ExporterWithTreePreOrderIterator::class);
    }
}
