<?php

namespace App\exporter\application\services\converter;


interface JsonToCvPartConverterInterface
{
    public function convert(object $json);
}
