<?php

declare(strict_types=1);

namespace App\exporter\application\services\converter\inputJsonSchemaV1;


use App\core\application\services\validators\JsonSchemaValidator;
use App\exporter\application\services\converter\JsonToCvPartConverterInterface;
use App\exporter\domain\model\CV;
use Traversable;

class JsonToCvConverter
{
    /** @var array<int, JsonToCvPartConverterInterface>  */
    private array $jsonToCvPartConverters;

    private JsonSchemaValidator $jsonSchemaValidator;

    private string $cvSchemaV1;

    /**
     * @param iterable<int, JsonToCvPartConverterInterface> $jsonToCvPartConverters
     */
    public function __construct(
        Traversable $jsonToCvPartConverters,
        JsonSchemaValidator $jsonSchemaValidator,
        string $cvSchemaV1
    ) {
        $this->jsonToCvPartConverters = iterator_to_array($jsonToCvPartConverters);
        $this->jsonSchemaValidator = $jsonSchemaValidator;
        $this->cvSchemaV1 = $cvSchemaV1;
    }

    public function convert(string $json): ?CV
    {
        $this->jsonSchemaValidator->validate($json, $this->cvSchemaV1);
        $jsonObject = json_decode($json);

        $cvParts = [];
        foreach($this->jsonToCvPartConverters as $key => $converter) {
            /** @var JsonToCvPartConverterInterface $converter */
            $cvParts[$key] = $converter->convert($jsonObject); // Strategy Pattern
        }

        return CV::fromIndexedArray($cvParts);
    }
}
