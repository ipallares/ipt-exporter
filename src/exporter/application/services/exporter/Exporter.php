<?php

declare(strict_types=1);

namespace App\exporter\application\services\exporter;

use App\exporter\domain\model\CV;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\ports\DocumentTypeExporterInterface;
use App\exporter\domain\services\interfaces\ContentLengthTypeExporterInterface;
use InvalidArgumentException;
use Traversable;

abstract class Exporter
{
    /** @var array<int, DocumentTypeExporterInterface> */
    private array $documentTypeExporters;

    /** @var array<int, DocumentTypeExporterInterface> */
    private array $contentLengthTypeExporters;

    /**
     * @param array<int, DocumentTypeExporterInterface> $documentTypeExporters
     */
    public function __construct(Traversable $documentTypeExporters, Traversable $contentLengthTypeExporters)
    {
        $this->documentTypeExporters = iterator_to_array($documentTypeExporters);
        $this->contentLengthTypeExporters = iterator_to_array($contentLengthTypeExporters);
    }

    public function export(CV $cv, string $documentType, string $contentLengthType ): string
    {

        $documentTypeExporter = $this->getDocumentTypeExporter($documentType);
        $contentLengthTypeExporter = $this->getContentLengthTypeExporter($contentLengthType);

        $recruiterHeader = $this->exportRecruiterHeader($documentTypeExporter);
        $personalDetails = $this->exportPersonalDetails(
            $cv->getPersonalDetails(),
            $documentTypeExporter,
            $contentLengthTypeExporter
        );
        $coverLetter = $this->exportCoverLetter(
            $cv->getCoverLetter(),
            $documentTypeExporter,
            $contentLengthTypeExporter
        );
        $recruiterBanner = $this->exportRecruiterBanner($documentTypeExporter);
        $body = $this->exportBody($cv, $documentTypeExporter, $contentLengthTypeExporter);

        return $recruiterHeader . $personalDetails . $coverLetter . $recruiterBanner . $body;
    }

    private function exportRecruiterBanner(DocumentTypeExporterInterface $documentTypeExporter): string
    {
        return $documentTypeExporter->addContent(
            '<recruiterbanner></recruiterbanner>'
        );
    }

    private function exportRecruiterHeader(DocumentTypeExporterInterface $documentTypeExporter)
    {
        return $documentTypeExporter->addContent(
            '<recruiterheader>My Awesome Recruitment Company</recruiterheader>'
        );
    }

    private function exportCoverLetter(
        CoverLetter $coverLetter,
        DocumentTypeExporterInterface $documentTypeExporter,
        ContentLengthTypeExporterInterface $contentLengthTypeExporter
    ): string {

        return $documentTypeExporter->addContent(
            $contentLengthTypeExporter->coverLetter($coverLetter)
        );
    }

    private function exportPersonalDetails(
        PersonalDetails $personalDetails,
        DocumentTypeExporterInterface $documentTypeExporter,
        ContentLengthTypeExporterInterface $contentLengthTypeExporter
    ): string {

        return $documentTypeExporter->addContent(
            $contentLengthTypeExporter->personalDetails($personalDetails)
        );
    }

    private function getContentLengthTypeExporter(string $contentLengthType): ContentLengthTypeExporterInterface
    {
        foreach($this->contentLengthTypeExporters as $contentLengthTypeExporter) {
            /** @var ContentLengthTypeExporterInterface $contentLengthTypeExporter */
            if ($contentLengthTypeExporter->supports($contentLengthType)) {
                return $contentLengthTypeExporter;
            }
        }
        throw new InvalidArgumentException("'$contentLengthType' is not supported by any exporter.");
    }

    private function getDocumentTypeExporter(string $documentType): DocumentTypeExporterInterface
    {
        foreach($this->documentTypeExporters as $documentTypeExporter) {
            /** @var DocumentTypeExporterInterface $documentTypeExporter */
            if ($documentTypeExporter->supports($documentType)) {
                return $documentTypeExporter;
            }
        }
        throw new InvalidArgumentException("'$documentType' is not supported by any exporter.");
    }

    /**
     * Template Pattern.
     *
     * The idea is that different implementations of this method will show Work and Academic experience
     * in different order (basically work-first or academic-first).
     *
     * This first approach is not so ready for adding new sections ("skills", "contacts for references"...) to the CV's
     * body and supporting all possible order combinations of them.
     *
     * By now the whole CV will be passed (a compromise between passing only what it needs and allowing some flexibility
     * if the CV grows, so we avoid touching the method's header).
     *
     * A better solution can be implemented splitting the code into services so each service takes care of exporting one
     * single section in the document. This allows us more flexibility to manage them and add new sections while keeping
     * the OCP principle.
     */
    abstract protected function exportBody(
        CV $cv,
        DocumentTypeExporterInterface $documentTypeExporter,
        ContentLengthTypeExporterInterface $contentLengthTypeExporter): string;
}
