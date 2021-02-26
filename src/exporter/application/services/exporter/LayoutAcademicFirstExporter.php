<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\exporter\domain\model\CV;
use App\exporter\domain\ports\DocumentTypeExporterInterface;
use App\exporter\domain\services\interfaces\ContentLengthTypeExporterInterface;

class LayoutAcademicFirstExporter extends Exporter
{
    protected function exportBody(
        CV $cv,
        DocumentTypeExporterInterface $documentTypeExporter,
        ContentLengthTypeExporterInterface $contentLengthTypeExporter
    ): string {

        $academicExperiences =  $documentTypeExporter->addContent(
            $contentLengthTypeExporter->academicExperience($cv->getAcademicExperiences())
        );

        $workExperiences =  $documentTypeExporter->addContent(
            $contentLengthTypeExporter->workExperience($cv->getWorkExperiences())
        );

        return $academicExperiences . $workExperiences;
    }
}
