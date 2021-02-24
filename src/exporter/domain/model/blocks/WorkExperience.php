<?php

declare(strict_types=1);

namespace App\exporter\domain\model\blocks;

use App\exporter\domain\model\interfaces\MultipleContentLengthExportInterface;

class WorkExperience implements MultipleContentLengthExportInterface
{
    private string $companyName;
    private string $position;
    private DateRange $dateRange;
    private string $tasksDescription;

    public function __construct(string $companyName, string $position, DateRange $dateRange, string $tasksDescription)
    {
        $this->companyName = $companyName;
        $this->position = $position;
        $this->dateRange = $dateRange;
        $this->tasksDescription = $tasksDescription;
    }

    public function exportCompressed(): string
    {
        return '<compressed-workexperience>'
            . $this->exportDateRange()
            . $this->exportCompanyName()
            . $this->exportPosition()
            . '</compressed-workexperience>';
    }

    public function exportExtended(): string
    {
        return '<extended-workexperience>'
            . $this->exportDateRange()
            . $this->exportCompanyName()
            . $this->exportPosition()
            . $this->exportTaskDescription()
            . '</extended-workexperience>';
    }

    private function exportCompanyName()
    {
        return "<companyname>$this->companyName</companyname>";
    }

    private function exportPosition()
    {
        return "<position>$this->position</position>";
    }

    private function exportDateRange()
    {
        return $this->dateRange->export();
    }

    private function exportTaskDescription()
    {
        return "<taskdescription>$this->tasksDescription</taskdescription>";
    }
}
