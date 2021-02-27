<?php

declare(strict_types=1);

namespace App\exporter\application\services\factory;

use App\core\application\services\validators\JsonSchemaValidator;
use App\exporter\domain\services\CvFieldExporterLeaf;
use App\exporter\domain\services\CvSectionExporterComposite;
use App\exporter\domain\services\interfaces\CvPartExporterComponentInterface;

class CompositeExporterFactory
{
    private JsonSchemaValidator $jsonSchemaValidator;

    private string $cvSchemaV1;

    public function __construct(
        JsonSchemaValidator $jsonSchemaValidator,
        string $cvSchemaV1
    ) {
        $this->jsonSchemaValidator = $jsonSchemaValidator;
        $this->cvSchemaV1 = $cvSchemaV1;
    }

    public function create(
        string $json
    ): CvPartExporterComponentInterface {
        $this->jsonSchemaValidator->validate($json, $this->cvSchemaV1);

        return $this->createPart(
            'CV',
            json_decode($json, true)
        );
    }

    private function createPart(string $title, array $parts): CvPartExporterComponentInterface
    {
        $component = new CvSectionExporterComposite($title);
        foreach($parts as $key => $part) {
            $subPartTitle = $this->getPartTitle($key);
            if (is_string($part)) {
                $component->addComponent(new CvFieldExporterLeaf($subPartTitle, $part));
                continue;
            }
            $component->addComponent($this->createPart($subPartTitle, $part));
        }

        return $component;
    }

    private function getPartTitle($key): string
    {
        return is_int($key) ? '' : $key;
    }
}
