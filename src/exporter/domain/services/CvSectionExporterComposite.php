<?php

declare(strict_types=1);

namespace App\exporter\domain\services;

use App\exporter\domain\ports\DocumentTypeExporterInterface;
use App\exporter\domain\services\interfaces\CvPartExporterComponentInterface;

class CvSectionExporterComposite implements CvPartExporterComponentInterface
{
    private string $title;

    /** @var array<int, CvPartExporterComponentInterface> */
    private array $components;

    /**
     * @param array<int, CvPartExporterComponentInterface> $components
     */
    public function __construct(string $title, array $components = [])
    {
        $this->title = $title;
        $this->components = $components;
    }

    public function export(DocumentTypeExporterInterface $documentTypeExporter): string
    {
        $componentsText = $this->convertComponentsToExportString($documentTypeExporter);

        $tag = $this->getWrappingTag($this->title);

        return $documentTypeExporter->addContent("<$tag>$componentsText</$tag>");
    }

    private function getWrappingTag(string $tag): string
    {
        return '' === $tag
            ? 'section-block'
            : $tag;
    }

    public function addComponent(CvPartExporterComponentInterface $component): void
    {
        $this->components[] = $component;
    }

    private function convertComponentsToExportString(DocumentTypeExporterInterface $documentTypeExporter)
    {
        $result = '';
        foreach($this->components as $component) {
            $result .= $component->export($documentTypeExporter);
        }

        return $result;
    }
}
